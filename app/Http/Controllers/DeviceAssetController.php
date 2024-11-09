<?php

namespace App\Http\Controllers;

use App\Models\DeviceAsset;
use App\Models\Device;
use App\Models\Asset;
use App\Models\Status;
use Illuminate\Http\Request;

class DeviceAssetController extends Controller
{
    public function index()
    {
        $deviceAssets = DeviceAsset::all();
        return view('device_assets.index', ['deviceAssets' => $deviceAssets]);
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
            'state_date' => 'nullable|date',
            'stop_date' => 'nullable|date',
            'status_id' => 'nullable|exists:statuses,id',
            'note' => 'nullable|string',
            'note2' => 'nullable|string',
            'note3' => 'nullable|string',
        ]);

        DeviceAsset::create($validatedData);

        return redirect()->route('device_assets.index')->with('success', 'DeviceAsset created successfully!');
    }

    // Add other CRUD methods (show, edit, update, destroy) as needed
}