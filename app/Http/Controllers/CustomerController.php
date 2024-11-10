<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('number', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('note', 'like', "%{$search}%")
                  ->orWhere('note2', 'like', "%{$search}%")
                  ->orWhere('note3', 'like', "%{$search}%");
        }

        $customers = $query->paginate(10); // Use pagination for better performance

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'number' => 'nullable|string',
            'name' => 'required|string|unique:customers',
            'note' => 'nullable|string',
            'note2' => 'nullable|string',
            'note3' => 'nullable|string',
        ]);

        // Create a new customer
        Customer::create($validatedData);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully!');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'number' => 'nullable|string',
            'name' => 'required|string|unique:customers,name,' . $customer->id,
            'note' => 'nullable|string',
            'note2' => 'nullable|string',
            'note3' => 'nullable|string',
        ]);

        $customer->update($validatedData);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully!');
    }
}