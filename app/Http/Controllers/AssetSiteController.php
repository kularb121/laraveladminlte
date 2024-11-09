<?php

namespace App\Http\Controllers;

use App\Models\AssetSite;
use App\Models\Asset;
use App\Models\Site;
use App\Models\Status;
use Illuminate\Http\Request;

class AssetSiteController extends Controller
{
    public function index()
    {
        $assetSites = AssetSite::all();
        return view('asset_sites.index', ['assetSites' => $assetSites]);
    }

    public function create()
    {
        $assets = Asset::all();
        $sites = Site::all();
        $statuses = Status::all();
        return view('asset_sites.create', [
            'assets' => $assets, 
            'sites' => $sites, 
            'statuses' => $statuses
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'site_id' => 'required|exists:sites,id',
            'start_date' => 'nullable|date',
            'stop_date' => 'nullable|date',
            'status_id' => 'nullable|exists:statuses,id',
            'note' => 'nullable|string',
            'note2' => 'nullable|string',
            'note3' => 'nullable|string',
        ]);

        AssetSite::create($validatedData);

        return redirect()->route('asset_sites.index')->with('success', 'AssetSite created successfully!');
    }

    // Add other CRUD methods (show, edit, update, destroy) as needed
}