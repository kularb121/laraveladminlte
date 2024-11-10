<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Customer;
use App\Models\Status;
use Illuminate\Http\Request;


class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::with('status')->get();
        return view('devices.index', compact('devices'));        
    }

    public function create()
    {

        $customers = Customer::orderBy('name', 'asc')->get(); // Fetch customers sorted by name
        // $customers = Customer::all();
        $statuses = Status::orderBy('name', 'asc')->get(); // Fetch statuses sorted by name
         // $statuses = Status::all();       
        // $statuses = Status::all();
        return view('devices.create', ['customers' => $customers, 'statuses' => $statuses]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'number' => 'required|string|unique:devices',
            'name' => 'nullable|string',
            'status_id' => 'nullable|exists:statuses,id',
            'mobile_number' => 'nullable|string',
            'manu_date' => 'required|date',
            'customer_id' => 'nullable|exists:customers,id',
            'note' => 'nullable|string',
            'note2' => 'nullable|string',
            'note3' => 'nullable|string',
        ]);

        Device::create($validatedData);

        return redirect()->route('devices.index')->with('success', 'Device created successfully!');
    }
    
    public function edit($id)
    {
        $device = Device::findOrFail($id);
        $statuses = Status::orderBy('name', 'asc')->get(); // Retrieve all statuses
        $customers = Customer::orderBy('name', 'asc')->get(); 
        // $statuses = Status::all(); // Retrieve all statuses
        // $customers = Customer::all(); // Retrieve all customers

        return view('devices.edit', compact('device', 'statuses', 'customers'));       
        // return view('devices.edit', compact('device'));
    }

    // public function edit(Device $device)
    // {
        
    //     return view('devices.edit', compact('device'));
    // }

    public function update(Request $request, Device $device)
    {
        $validatedData = $request->validate([
            'number' => 'required|string|unique:devices,number,' . $device->id,
            'name' => 'nullable|string',
            'status_id' => 'nullable|exists:statuses,id',
            'mobile_number' => 'nullable|string',
            'manu_date' => 'required|date',
            'customer_id' => 'nullable|exists:customers,id',
            'note' => 'nullable|string',
            'note2' => 'nullable|string',
            'note3' => 'nullable|string',
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
