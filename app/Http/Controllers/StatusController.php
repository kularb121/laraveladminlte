<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status; // Import the Status model

class StatusController extends Controller
{
    //
    public function index()
    {
        $statuses = Status::all(); 
        return view('statuses.index', ['statuses' => $statuses]); 
    }

    public function create()
    {
        return view('statuses.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new status
        Status::create($validatedData);

        // Redirect to the statuses index page
        return redirect()->route('statuses.index');
    }
}
