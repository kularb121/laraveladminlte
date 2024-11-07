<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device; // Import the Device model


class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::all(); // Fetch all devices from the database
    
        return view('devices.index', ['devices' => $devices]); // Pass the data to the view
    }

    public function create()
    {
        return view('devices.create');
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
}
