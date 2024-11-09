<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', ['customers' => $customers]);
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'number' => 'required|string|unique:customers',
            'name' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        // Create a new customer
        Customer::create($validatedData);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully!');
    }

    // Add other CRUD methods (show, edit, update, destroy) as needed
}