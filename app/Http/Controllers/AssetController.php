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
        $asset->load('devices.telemetries', 'sites'); // Load necessary relationships

        $telemetryData = [];
        if ($asset->devices->isNotEmpty()) {
            foreach ($asset->devices as $device) {
                if ($device->customer) { 
                    // Access customer attributes through the device's customer relationship
                    $attributes = $device->customer->attributes;

                    foreach ($attributes as $attribute) {
                        $telemetry = $device->telemetries()->where('key', $attribute->name)->latest('timestamp')->first();

                        $telemetryData[$device->id][$attribute->name] = [
                            'value' => $telemetry?->value,
                            'unit' => $attribute->unit,
                            'display_type' => $attribute->display_type,
                        ];

                        // Calculate temperature percentage only if the attribute is 'temperature'
                        if ($attribute->name === 'temperature' && $telemetry) {
                            $temperature = (float) $telemetry->value;
                            $minTemp = 0; // Replace with your actual minimum temperature
                            $maxTemp = 100; // Replace with your actual maximum temperature
                            $telemetryData[$device->id][$attribute->name]['temperaturePercentage'] = ($temperature - $minTemp) / ($maxTemp - $minTemp) * 100;
                        }
                    }
                }
            }
        }

        return view('assets.dashboard', [
            'asset' => $asset,
            'telemetryData' => $telemetryData,
        ]);
    }

    // public function showDashboard(Asset $asset)
    // {
    //     $asset->load('devices.telemetries', 'sites'); // Load necessary relationships

    //     $telemetryData = [];
    //     foreach ($asset->devices as $device) {
    //         // Access customer attributes through the device's customer relationship
    //         $attributes = $device->customer->attributes;
            
    //         foreach ($attributes as $attribute) {
    //             $telemetry = $device->telemetries()->where('key', $attribute->name)->latest('timestamp')->first();

    //             //$telemetry = $device->telemetries()->whereRaw('LOWER(key) = ?', [strtolower($attribute->name)])->latest('timestamp')->first();

    //             $telemetryData[$device->id][$attribute->name] = [
    //                 'value' => $telemetry?->value,
    //                 'unit' => $attribute->unit,
    //                 'display_type' => $attribute->display_type,
    //             ];
    
    //             // Calculate temperature percentage only if the attribute is 'temperature'
    //             if ($attribute->name === 'temperature' && $telemetry) {
    //                 $temperature = (float) $telemetry->value;
    //                 $minTemp = 0; // Replace with your actual minimum temperature
    //                 $maxTemp = 100; // Replace with your actual maximum temperature
    //                 $telemetryData[$device->id][$attribute->name]['temperaturePercentage'] = ($temperature - $minTemp) / ($maxTemp - $minTemp) * 100;
    //             }
    //         }
    //     }

    //     return view('assets.dashboard', [
    //         'asset' => $asset,
    //         'telemetryData' => $telemetryData,
    //     ]);
    // }


    // public function showDashboard(Asset $asset)
    // {
    //     $asset->load('devices.telemetries', 'sites'); // Load necessary relationships

    //     $telemetryData = [];
    //     foreach ($asset->devices as $device) {
    //         // Access customer attributes through the device's customer relationship
            
    //         foreach ($device->customer->attributes as $attribute) { 
    //             $telemetry = $device->telemetries()->where('key', $attribute->name)->latest('timestamp')->first();

    //             $telemetryData[$device->id][$attribute->name] = [
    //                 'value' => $telemetry?->value,
    //                 'unit' => $attribute->unit,
    //                 'display_type' => $attribute->display_type,
    //             ];
    //         }
    //     }

    //     return view('assets.dashboard', [
    //         'asset' => $asset,
    //         'telemetryData' => $telemetryData,
    //     ]);
    // }
   
    public function temperatureHistory(Asset $asset, Device $device, Request $request)
    {
        $hours = $request->input('hours', 10);

        // Ensure the device has a customer and the 'temperature' attribute is enabled for that customer
        if ($device->customer && $device->customer->attributes()->where('name', 'temperature')->exists()) { 
            $temperatureHistory = $device->telemetries()
                ->where('key', 'temperature')
                ->where('timestamp', '>=', now()->subHours($hours))
                ->get();

            // Prepare data for Chart.js
            $labels = $temperatureHistory->pluck('timestamp')->map(function ($timestamp) {
                return \Carbon\Carbon::parse($timestamp)->format('Y-m-d H:i:s');
            });
            $data = $temperatureHistory->pluck('value');

            return response()->json([
                'labels' => $labels,
                'data' => $data,
            ]);
        } else {
            // Return an empty response or an error message if the attribute is not enabled for the customer
            return response()->json([
                'labels' => [],
                'data' => [],
            ]);
        }
    }

    public function download(Asset $asset, Device $device, Request $request)
    {
        $startDate = $request->input('start_date');
        $untilDate = $request->input('until_date');

        // Fetch telemetry data for the device within the specified date range, but only for attributes enabled for the customer
        $telemetries = $device->telemetries()
            ->whereIn('key', $device->customer->attributes->pluck('name')) 
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


    // public function download(Asset $asset, Device $device, Request $request)
    // {
    //     $startDate = $request->input('start_date');
    //     $untilDate = $request->input('until_date');

    //     // Fetch telemetry data for the device within the specified date range
    //     $telemetries = $device->telemetries()
    //         ->whereBetween('timestamp', [$startDate, $untilDate])
    //         ->get();

    //     // Generate CSV data
    //     $csvData = $telemetries->map(function ($telemetry) {
    //         return [
    //             'timestamp' => $telemetry->timestamp,
    //             'key' => $telemetry->key,
    //             'value' => $telemetry->value,
    //         ];
    //     });

    //     // Create the CSV writer
    //     // $csv = Writer::createFromString('');
    //     // $csv->insertOne(['Timestamp', 'Key', 'Value']); // Add header row
    //     // $csv->insertAll($csvData);

    //     // Create the CSV writer (using a temporary file)
    //     $csv = Writer::createFromFileObject(new \SplTempFileObject()); 
    //     $csv->insertOne(['Timestamp', 'Key', 'Value']); 
    //     $csv->insertAll($csvData);

    //     // Set headers for download
    //     $headers = [
    //         'Content-Type' => 'text/csv',
    //         'Content-Disposition' => 'attachment; filename="telemetry_data.csv"',
    //     ];

    //     // Return the CSV as a download response (using streamDownload with an anonymous function)
    //     return response()->streamDownload(function () use ($csv) {
    //         $output = $csv->toString(); 
    //         echo $output;
    //     }, 'telemetry_data.csv', $headers);
    // }
}