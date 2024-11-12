<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Models\Telemetry;

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
        $asset->load('devices.telemetries', 'sites'); // Correctly load the 'sites' relationship on the Asset model

        $telemetryData = [];
        foreach ($asset->devices as $device) {
            $telemetryData[$device->id] = [
                'temperature' => $device->telemetries()->where('key', 'temperature')->latest('timestamp')->value('value'),
                'humidity' => $device->telemetries()->where('key', 'humidity')->latest('timestamp')->value('value'),
                'temperatureHistory' => $device->telemetries()
                    ->where('key', 'temperature')
                    ->where('timestamp', '>=', now()->subHours(10))
                    ->get(),
            ];
        }

        return view('assets.dashboard', [
            'asset' => $asset,
            'telemetryData' => $telemetryData,
        ]);

    }
}