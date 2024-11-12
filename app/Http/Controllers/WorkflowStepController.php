<?php

namespace App\Http\Controllers;

use App\Models\Workflow;
use App\Models\WorkflowStep;
use Illuminate\Http\Request;

class WorkflowStepController extends Controller
{
    public function store(Request $request, Workflow $workflow)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer',
            'assigned_to' => 'nullable|exists:users,id', 
            'status' => 'required|string|in:pending,in_progress,completed', 
        ]);

        $workflow->steps()->create($validatedData);

        return redirect()->route('workflows.show', $workflow)->with('success', 'Step added to workflow!');
    }

    public function update(Request $request, Workflow $workflow, WorkflowStep $step) 
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|string|in:pending,in_progress,completed',
        ]);

        $step->update($validatedData);

        return redirect()->route('workflows.show', $workflow)->with('success', 'Step updated!');
    }

    public function destroy(Workflow $workflow, WorkflowStep $step) 
    {
        $step->delete();
        return redirect()->route('workflows.show', $workflow)->with('success', 'Step removed from workflow!');
    }

    public function reorder(Request $request, Workflow $workflow, WorkflowStep $step)
    {
        $validatedData = $request->validate([
            'order' => 'required|integer',
        ]);

        $step->update(['order' => $validatedData['order']]);

        return response()->json(['message' => 'Step reordered successfully!']);
    }
}