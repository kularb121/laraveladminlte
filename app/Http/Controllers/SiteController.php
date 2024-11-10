<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Customer;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $sites = Site::with('customer')->get();
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
            'name' => 'required|string|unique:sites,name,' . $site->id,
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