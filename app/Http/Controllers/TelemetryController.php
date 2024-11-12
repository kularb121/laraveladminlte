<?php

namespace App\Http\Controllers;

use App\Models\Telemetry;
use Illuminate\Http\Request;

class TelemetryController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming telemetry data
        $validatedData = $request->validate([
            'device_id' => 'required|exists:devices,id',
            'key' => 'required|string',
            'value' => 'required|string', 
            // Add more validation rules as needed
        ]);

        // Create a new telemetry record
        Telemetry::create($validatedData);

        // Return a success response
        return response()->json(['message' => 'Telemetry data received successfully!'], 201); 
    }

    public function index()
    {
        $telemetries = Telemetry::with('device')->paginate(10); // Paginate for better performance
        return view('telemetries.index', compact('telemetries'));
    }

    public function show(Telemetry $telemetry)
    {
        return view('telemetries.show', compact('telemetry'));
    }

    public function destroy(Telemetry $telemetry)
    {
        $telemetry->delete();
        return redirect()->route('telemetries.index')->with('success', 'Telemetry data deleted successfully!');
    }
}