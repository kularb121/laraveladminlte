<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Models\DeviceAttribute;

class DeviceAttributeController extends Controller
{
    public function index(Device $device)
    {
        $attributes = $device->attributes;
        return view('devices.attributes.index', compact('device', 'attributes'));
    }

    public function create(Device $device)
    {
        return view('devices.attributes.create', compact('device'));
    }

    public function store(Request $request, Device $device)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:255',
            'display_type' => 'required|string|in:value,chart',
        ]);

        $device->attributes()->create($validatedData);

        return redirect()->route('devices.attributes.index', $device)
            ->with('success', 'Attribute added to device!');
    }

    public function edit(Device $device, DeviceAttribute $attribute)
    {
        return view('devices.attributes.edit', compact('device', 'attribute'));
    }

    public function update(Request $request, Device $device, DeviceAttribute $attribute)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:255',
            'display_type' => 'required|string|in:value,chart',
        ]);

        $attribute->update($validatedData);

        return redirect()->route('devices.attributes.index', $device)
            ->with('success', 'Attribute updated!');
    }

    public function destroy(Device $device, DeviceAttribute $attribute)
    {
        $attribute->delete();
        return redirect()->route('devices.attributes.index', $device)
            ->with('success', 'Attribute deleted!');
    }
}