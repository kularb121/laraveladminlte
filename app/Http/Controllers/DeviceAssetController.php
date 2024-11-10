<?php

namespace App\Http\Controllers;

use App\Models\DeviceAsset;
use App\Models\Device;
use App\Models\Asset;
use App\Models\Status;
use Illuminate\Http\Request;

class DeviceAssetController extends Controller
{
    // public function index()
    // {
    //     $device_assets = DeviceAsset::all();
    //     return view('device_assets.index', ['device_assets' => $device_assets]);
    // }

    public function index(Request $request)
    {
        $query = DeviceAsset::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('device', function ($q) use ($search) {
                      $q->where('number', 'like', "%{$search}%");
                  })
                  ->orWhereHas('asset', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('status', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhere('note', 'like', "%{$search}%")
                  ->orWhere('note2', 'like', "%{$search}%")
                  ->orWhere('note3', 'like', "%{$search}%");
        }

        $device_assets = $query->paginate(10); // Use pagination for better performance

        return view('device_assets.index', compact('device_assets'));
    }
    

    public function create()
    {
        $devices = Device::all();
        $assets = Asset::all();
        $statuses = Status::all();
        return view('device_assets.create', [
            'devices' => $devices, 
            'assets' => $assets, 
            'statuses' => $statuses
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'device_id' => 'required|exists:devices,id',
            'asset_id' => 'required|exists:assets,id',
            'start_date' => 'nullable|date',
            'stop_date' => 'nullable|date',
            'status_id' => 'nullable|exists:statuses,id',
            'note' => 'nullable|string',
            'note2' => 'nullable|string',
            'note3' => 'nullable|string',
        ]);

        DeviceAsset::create($validatedData);

        return redirect()->route('device_assets.index')->with('success', 'DeviceAsset created successfully!');
    }

    public function edit(DeviceAsset $device_asset)
    {
        $devices = Device::orderBy('name', 'asc')->get();
        $assets = Asset::orderBy('name', 'asc')->get();
        $statuses = Status::orderBy('name', 'asc')->get();
        return view('device_assets.edit', compact('device_asset', 'devices', 'assets', 'statuses'));
    }

    public function update(Request $request, DeviceAsset $device_asset)
    {
        $validatedData = $request->validate([
            'device_id' => 'required|exists:devices,id',
            'asset_id' => 'required|exists:assets,id',
            'start_date' => 'nullable|date',
            'stop_date' => 'nullable|date',
            'status_id' => 'nullable|exists:statuses,id',
            'note' => 'nullable|string',
            'note2' => 'nullable|string',
            'note3' => 'nullable|string',
        ]);

        $device_asset->update($validatedData);

        return redirect()->route('device_assets.index')->with('success', 'Device Asset updated successfully!');
    }

    public function destroy(DeviceAsset $device_asset)
    {
        $device_asset->delete();

        return redirect()->route('device_assets.index')->with('success', 'Device Asset deleted successfully!');
    }
}