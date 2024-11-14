<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Customer;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        $query = Site::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('number', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhere('note', 'like', "%{$search}%")
                  ->orWhere('note2', 'like', "%{$search}%")
                  ->orWhere('note3', 'like', "%{$search}%");
        }

        $sites = $query->paginate(10); // Use pagination for better performance

        return view('sites.index', compact('sites'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name', 'asc')->get();
        return view('sites.create', compact('customers'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'number' => 'nullable|string',
            'name' => 'required|string|unique:sites',
            'customer_id' => 'nullable|exists:customers,id',
            'note' => 'nullable|string',
            'note2' => 'nullable|string',
            'note3' => 'nullable|string',
        ]);

        // Create a new site
        Site::create($validatedData);

        return redirect()->route('sites.index')->with('success', 'Site created successfully!');
    }

    public function edit(Site $site)
    {
        $customers = Customer::orderBy('name', 'asc')->get();
        return view('sites.edit', compact('site', 'customers'));
    }

    public function update(Request $request, Site $site)
    {
        $validatedData = $request->validate([
            'number' => 'nullable|string',
            'name' => 'required|string|unique:sites,name,' . $site->uuid,
            'customer_id' => 'nullable|exists:customers,id',
            'note' => 'nullable|string',
            'note2' => 'nullable|string',
            'note3' => 'nullable|string',
        ]);

        $site->update($validatedData);

        return redirect()->route('sites.index')->with('success', 'Site updated successfully!');
    }

    public function destroy(Site $site)
    {
        $site->delete();

        return redirect()->route('sites.index')->with('success', 'Site deleted successfully!');
    }
    // Add other CRUD methods (show, edit, update, destroy) as needed
}