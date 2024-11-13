<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerAttribute;

class CustomerAttributeController extends Controller
{
    // public function index(Customer $customer)
    // {
    //     $attributes = $customer->attributes;
    //     return view('customers.attributes.index', compact('customer', 'attributes'));
    // }
    public function index()
    {
        $customerAttributes = CustomerAttribute::with('customer')->get();
        return view('customer_attributes.index', compact('customerAttributes'));
    }

    public function create(Customer $customer)
    {
        $customers = Customer::all();
        return view('customers.attributes.create', compact('customer'));
    }

    public function store(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:255',
            'display_type' => 'required|string|in:value,chart',
        ]);

        $customer->attributes()->create($validatedData);

        return redirect()->route('customers.attributes.index', $customer)
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