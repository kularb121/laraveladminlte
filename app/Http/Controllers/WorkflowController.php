<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workflow;
use App\Models\WorkflowStep;
use Illuminate\Http\Request;

class WorkflowController extends Controller
{
    public function index()
    {
        $workflows = Workflow::all();
        $users = User::all(); // Fetch all users
        return view('workflows.index', compact('workflows', 'users'));
    }

    public function create()
    {
        return view('workflows.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string', 
            'due_date' => 'nullable|date',
            'step_name' => 'required|array', 
            'step_name.*' => 'required|string|max:255', 
            'step_description' => 'nullable|array',
            'step_assigned_to' => 'nullable|array',
            'step_assigned_to.*' => 'nullable|exists:users,id', 
        ]);

        $workflow = Workflow::create($request->only(['name', 'description', 'due_date']));

        $stepsData = [];
        for ($i = 0; $i < count($validatedData['step_name']); $i++) {
            $stepsData[] = [
                'name' => $validatedData['step_name'][$i],
                'description' => $validatedData['step_description'][$i] ?? null,
                'assigned_to' => $validatedData['step_assigned_to'][$i] ?? null,
                'order' => $i + 1, 
            ];
        }
        $workflow->steps()->createMany($stepsData);

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