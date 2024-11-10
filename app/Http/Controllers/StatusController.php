<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status; // Import the Status model

class StatusController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Status::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('number', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('note', 'like', "%{$search}%");
        }

        $statuses = $query->paginate(10); // Use pagination for better performance

        return view('statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('statuses.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'number' => 'nullable|string',
            'name' => 'required|string|max:255',
            'note' => 'nullable|string',
        ]);

        // Create a new status
        Status::create($validatedData);

        return redirect()->route('statuses.index')->with('success', 'Status created successfully!');
    }

    
    public function edit(Status $status)
    {
        return view('statuses.edit', compact('status'));
    }

    public function update(Request $request, Status $status)
    {
        $validatedData = $request->validate([
            'number' => 'nullable|string',
            'name' => 'required|string|max:255',
            'note' => 'nullable|string',
        ]);

        $status->update($validatedData);

        return redirect()->route('statuses.index')->with('success', 'Status updated successfully!');
    }

    public function destroy(Status $status)
    {
        $status->delete();

        return redirect()->route('statuses.index')->with('success', 'Status deleted successfully!');
    }
}
