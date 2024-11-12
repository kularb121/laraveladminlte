<?php

namespace App\Http\Controllers;

use App\Models\Workflow;
use Illuminate\Http\Request;

class WorkflowController extends Controller
{
    public function index()
    {
        $workflows = Workflow::all();
        return view('workflows.index', compact('workflows'));
    }

    public function create()
    {
        return view('workflows.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // Add validation rules for other fields as needed
        ]);

        Workflow::create($validatedData);

        return redirect()->route('workflows.index')->with('success', 'Workflow created successfully!');
    }

    public function show(Workflow $workflow)
    {
        return view('workflows.show', compact('workflow'));
    }

    public function edit(Workflow $workflow)
    {
        return view('workflows.edit', compact('workflow'));
    }

    public function update(Request $request, Workflow $workflow)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // Add validation rules for other fields as needed
        ]);

        $workflow->update($validatedData);

        return redirect()->route('workflows.index')->with('success', 'Workflow updated successfully!');
    }

    public function destroy(Workflow $workflow)
    {
        $workflow->delete();
        return redirect()->route('workflows.index')->with('success', 'Workflow deleted successfully!');
    }

    public function assignTask(Request $request, Workflow $workflow)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $workflow->update(['assigned_to' => $validatedData['user_id']]);

        return response()->json(['message' => 'Task assigned successfully!']);
    }

    public function updateStatus(Request $request, Workflow $workflow)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,in_progress,completed', // Example validation
        ]);

        $workflow->update($validatedData);

        return response()->json(['message' => 'Workflow status updated!']);
    }
}