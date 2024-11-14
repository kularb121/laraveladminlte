<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerAttribute;

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
            'name' => 'required|string|unique:customers,name,' . $customer->uuid,
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

    public function attributes(Customer $customer) 
    {
        $attributes = $customer->attributes; 
        return view('customers.attributes.index', compact('customer', 'attributes')); 
    }

    public function createAttribute()
    {
        $customerAttributes = CustomerAttribute::orderBy('name', 'asc')->get(); // Fetch all customer attributes with the associated customer
        $customers = Customer::orderBy('name', 'asc')->get(); // Fetch customers sorted by name
        return view('customers.attributes.create', compact('customerAttributes', 'customers'));
    }

    public function storeAttribute(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',            
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:255',
            'display_type' => 'required|string|in:value,chart',
        ]);

        CustomerAttribute::create($validatedData); 

        return redirect()->route('customers.attributes.index')->with('success', 'Attribute created!');
    }

    public function editAttribute(Customer $customer, CustomerAttribute $attribute)
    {
        return view('customers.attributes.edit', compact('customer', 'attribute'));
    }

    public function updateAttribute(Request $request, Customer $customer, CustomerAttribute $attribute)
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

    public function destroyAttribute(Customer $customer, CustomerAttribute $attribute)
    {
        $attribute->delete();
        return redirect()->route('customers.attributes.index')
            ->with('success', 'Attribute deleted!');
    }

    public function allAttributes(Request $request)
    {
        $query = CustomerAttribute::with('customer');
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('unit', 'like', "%{$search}%") 
                  ->orWhereHas('customer', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }
    
        $customerAttributes = $query->get();
        return view('customers.attributes.index', compact('customerAttributes'));
    }
}