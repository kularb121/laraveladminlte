<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Device;
use App\Models\Status;
use App\Models\Telemetry;
use Illuminate\Http\Request;
use League\Csv\Writer;


class AssetController extends Controller
{

    public function index(Request $request)
    {
        $query = Asset::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('number', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhereHas('status', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $assets = $query->paginate(10); // Use pagination for better performance

        return view('assets.index', compact('assets'));
    }
    public function create()
    {
        $statuses = Status::orderBy('name', 'asc')->get(); // Fetch statuses sorted by name
        // $statuses = Status::all();
        return view('assets.create', ['statuses' => $statuses]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'number' => 'nullable|string',
            'name' => 'required|string|unique:assets',
            'status_id' => 'nullable|exists:statuses,id',
            'note' => 'nullable|string',
            'note2' => 'nullable|string',
            'note3' => 'nullable|string',
        ]);

        Asset::create($validatedData);

        return redirect()->route('assets.index')->with('success', 'Asset created successfully!');
    }

    public function edit(Asset $asset)
    {
        $statuses = Status::orderBy('name', 'asc')->get(); // Fetch statuses sorted by name
        return view('assets.edit', compact('asset', 'statuses'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validatedData = $request->validate([
            'number' => 'nullable|string',
            'name' => 'required|string|unique:assets,name,' . $asset->id,
            'status_id' => 'nullable|exists:statuses,id',
            'note' => 'nullable|string',
            'note2' => 'nullable|string',
            'note3' => 'nullable|string',
        ]);

        $asset->update($validatedData);

        return redirect()->route('assets.index')->with('success', 'Asset updated successfully!');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        return redirect()->route('assets.index')->with('success', 'Asset deleted successfully!');
    }

    public function showDashboard(Asset $asset)
    {
        // $asset->load('devices.telemetries', 'sites'); // Correctly load the 'sites' relationship on the Asset model
        $asset->load('devices.attributes', 'devices.telemetries', 'sites');

        $telemetryData = [];
        foreach ($asset->devices as $device) {
            foreach ($device->attributes as $attribute) {
                $telemetry = $device->telemetries()->where('key', $attribute->name)->latest()->first();
    
                $telemetryData[$device->id][$attribute->name] = [
                    'value' => $telemetry?->value,
                    'unit' => $attribute->unit,
                    'display_type' => $attribute->display_type,
                ];
            }
        }

        return view('assets.dashboard', [
            'asset' => $asset,
            'telemetryData' => $telemetryData,
        ]);

        // Code befor using attributes.
        // foreach ($asset->devices as $device) {
        //     $telemetryData[$device->id] = [
        //         $temperature = $device->telemetries()->where('key', 'temperature')->latest('timestamp')->value('value'),
        //         $minTemp = 0,
        //         $maxTemp = 120,

        //         'temperature' => $temperature,
        //         'humidity' => $device->telemetries()->where('key', 'humidity')->latest('timestamp')->value('value'),
        //         'temperatureHistory' => $device->telemetries()
        //             ->where('key', 'temperature')
        //             ->where('timestamp', '>=', now()->subHours(10))
        //             ->get(),

        //         'temperaturePercentage' => ($temperature - $minTemp) / ($maxTemp - $minTemp) * 100, 
        //     ];
        // }

    }
    
    public function temperatureHistory(Asset $asset, Device $device, Request $request)
    {
        $hours = $request->input('hours', 10); 

        $temperatureHistory = $device->telemetries()
            ->where('key', 'temperature')
            ->where('timestamp', '>=', now()->subHours($hours))
            ->get();

        // Prepare data for Chart.js
        $labels = $temperatureHistory->pluck('timestamp')->map(function ($timestamp) {
            return \Carbon\Carbon::parse($timestamp)->format('Y-m-d H:i:s'); // Parse the string to Carbon        
        });
        $data = $temperatureHistory->pluck('value');

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function download(Asset $asset, Device $device, Request $request)
    {
        $startDate = $request->input('start_date');
        $untilDate = $request->input('until_date');

        // Fetch telemetry data for the device within the specified date range
        $telemetries = $device->telemetries()
            ->whereBetween('timestamp', [$startDate, $untilDate])
            ->get();

        // Generate CSV data
        $csvData = $telemetries->map(function ($telemetry) {
            return [
                'timestamp' => $telemetry->timestamp,
                'key' => $telemetry->key,
                'value' => $telemetry->value,
            ];
        });

        // Create the CSV writer
        // $csv = Writer::createFromString('');
        // $csv->insertOne(['Timestamp', 'Key', 'Value']); // Add header row
        // $csv->insertAll($csvData);

        // Create the CSV writer (using a temporary file)
        $csv = Writer::createFromFileObject(new \SplTempFileObject()); 
        $csv->insertOne(['Timestamp', 'Key', 'Value']); 
        $csv->insertAll($csvData);

        // Set headers for download
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="telemetry_data.csv"',
        ];

        // Return the CSV as a download response (using streamDownload with an anonymous function)
        return response()->streamDownload(function () use ($csv) {
            $output = $csv->toString(); 
            echo $output;
        }, 'telemetry_data.csv', $headers);
    }
}