<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Models\Device; // Import the Device model


class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::with('status')->get();
        return view('devices.index', compact('devices'));        
    }

    public function create()
    {
        $statuses = Status::all(); // Fetch all statuses
        return view('devices.create', compact('statuses'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data (optional but recommended)
        $request->validate([
            'name' => 'required|string|max:20',
            'manu_date' => 'required|date',
            'status' => 'required|integer',
            'note' => 'required|string|max:384',
        ]);

        // Create a new device record in the database
        Device::create([
            'name' => $request->input('name'),
            'manu_date' => $request->input('manu_date'),
            'status' => $request->input('status'),
            'note' => $request->input('note'),
        ]);

        // Redirect back to the devices index page
        return redirect()->route('devices.index'); 
    }
    
    public function edit(Device $device)
    {
        return view('devices.edit', compact('device'));
    }

    public function update(Request $request, Device $device)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'manu_date' => 'required|date',
            'status' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $device->update($validatedData);

        return redirect()->route('devices.index')->with('success', 'Device updated successfully!');
    }

    public function destroy(Device $device)
    {
        $device->delete();

        return redirect()->route('devices.index')->with('success', 'Device deleted successfully!');
    }    
}
