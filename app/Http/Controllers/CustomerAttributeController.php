<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerAttribute;

class CustomerAttributeController extends Controller
{
    public function index()
    {
        $attributes = CustomerAttribute::with('customer')->get(); // Fetch all attributes with their associated customers
        return view('customers.attributes.index', compact('attributes'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('customers.attributes.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:255',
            'display_type' => 'required|string|in:value,chart',
        ]);

        CustomerAttribute::create($validatedData);

        return redirect()->route('customers.attributes.index', $validatedData['customer_id'])
            ->with('success', 'Attribute added to customer!');
    }

    public function edit(Customer $customer, CustomerAttribute $attribute)
    {
        return view('customers.attributes.edit', compact('customer', 'attribute'));
    }

    public function update(Request $request, Customer $customer, CustomerAttribute $attribute)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:255',
            'display_type' => 'required|string|in:value,chart',
        ]);

        $attribute->update($validatedData);

        return redirect()->route('customers.attributes.index', $customer)
            ->with('success', 'Attribute updated!');
    }

    public function destroy(Customer $customer, CustomerAttribute $attribute)
    {
        $attribute->delete();
        return redirect()->route('customers.attributes.index', $customer)
            ->with('success', 'Attribute deleted!');
    }
}