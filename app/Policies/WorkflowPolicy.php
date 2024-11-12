<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workflow;

class WorkflowPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function manageSteps(User $user, Workflow $workflow)
    {
        // Your logic to determine if the user is authorized
        // For example, check if the user has a specific role or owns the workflow:
        return $user->hasRole('administrator') || $workflow->created_by === $user->id; 
    }
}
