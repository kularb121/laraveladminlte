<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Customer;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $sites = Site::all();
        return view('sites.index', ['sites' => $sites]);
    }

    public function create()
    {
        $customers = Customer::all();
        return view('sites.create', ['customers' => $customers]);
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

    // Add other CRUD methods (show, edit, update, destroy) as needed
}