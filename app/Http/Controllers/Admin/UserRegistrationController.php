<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserRegistrationController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create()
    {
        $roles = Role::all(); // Fetch all roles
        return view('admin.register', compact('roles'));
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        Log::info('Store method called');

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        Log::info('Validation passed', $validatedData);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        Log::info('User created', ['user' => $user]);

        return redirect()->route('admin.users.index')->with('success', 'User registered successfully!');
    }
}