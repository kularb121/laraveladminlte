<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Device;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Models\IotApplication;

class IotApplicationController extends Controller
{
    public function index()
    {
        $iotApplications = IotApplication::all();
        return view('iotapplications.index', ['iotapplications' => $iotApplications]);
    }

    public function create()
    {
        $devices = Device::all();
        $assets = Asset::all();
        $statuses = Status::all();

        return view('iotapplications.create', [
            'devices' => $devices,
            'assets' => $assets,
            'statuses' => $statuses,
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'device_id' => 'required|exists:devices,id',
            'asset_id' => 'required|exists:assets,id',
            'start_date' => 'required|date',
            'stop_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|exists:statuses,id',
            'note' => 'nullable|string',
        ]);

        // Create a new IoT application
        IotApplication::create($validatedData);

        return redirect()->route('iotapplications.index')->with('success', 'IoT Application created successfully!');
    }

    public function edit(IotApplication $iotapplication)
    {
        $devices = Device::all();
        $assets = Asset::all();
        $statuses = Status::all();

        return view('iotapplications.edit', [
            'iotapplication' => $iotapplication,
            'devices' => $devices,
            'assets' => $assets,
            'statuses' => $statuses,
        ]);
    }

    public function update(Request $request, IotApplication $iotapplication)
    {
        $validatedData = $request->validate([
            'device_id' => 'required|exists:devices,id',
            'asset_id' => 'required|exists:assets,id',
            'start_date' => 'required|date',
            'stop_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|exists:statuses,id',
            'note' => 'nullable|string',
        ]);

        $iotapplication->update($validatedData);

        return redirect()->route('iotapplications.index')->with('success', 'IoT Application updated successfully!');
    }

    public function destroy(IotApplication $iotapplication)
    {
        $iotapplication->delete();

        return redirect()->route('iotapplications.index')->with('success', 'IoT Application deleted successfully!');
    }
    // Add other CRUD methods (show, edit, update, destroy) as needed
}