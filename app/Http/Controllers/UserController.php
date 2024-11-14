<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $query->paginate(10); // Use pagination for better performance
        
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all(); // Fetch all roles
        return view('users.create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        Gate::authorize('create-users'); // Check if the user is authorized

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id', // Add validation for role_id
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        User::create($validatedData);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)], 
            'password' => 'nullable|string|min:8|confirmed', 'role_id' => 'required|exists:roles,id', // Add validation for role_id
            'role_id' => 'required|exists:roles,id', // Add validation for role_id
        ]);

        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);
 // Update including role_id
        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    // In UserController.php

    public function editRole(User $user)
    {
        $roles = Role::all();
        return view('users.edit-role', compact('user', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
    //    Gate::authorize('editRole', $user);  // Authorize the action (see step 4)
        Gate::authorize('edit-user-roles');  // Authorize the action
        $validatedData = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'User role updated successfully!');
    }

    public function show(User $user)
    {
        // Add your logic here to display the user details
        return view('users.show', compact('user'));
    }

    public function manageRoles()
    {
        Gate::authorize('edit-user-roles'); // Ensure only authorized users can access this

        //Gate::authorize('editRole'); // Ensure only authorized users can access this

        $users = User::with('role')->get(); // Eager load the roles
        return view('users.manage-roles', compact('users'));
    }

    
}