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
        $assetSites = AssetSite::with(['asset', 'site', 'status'])->get();
        return view('asset_sites.index', compact('assetSites'));
    }

    public function create()
    {
        $assets = Asset::orderBy('name', 'asc')->get();
        $sites = Site::orderBy('name', 'asc')->get();
        $statuses = Status::orderBy('name', 'asc')->get();
        return view('asset_sites.create', compact('assets', 'sites', 'statuses'));
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

    public function edit(AssetSite $assetSite)
    {
        $assets = Asset::orderBy('name', 'asc')->get();
        $sites = Site::orderBy('name', 'asc')->get();
        $statuses = Status::orderBy('name', 'asc')->get();
        return view('asset_sites.edit', compact('assetSite', 'assets', 'sites', 'statuses'));
    }

    public function update(Request $request, AssetSite $assetSite)
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

        $assetSite->update($validatedData);

        return redirect()->route('asset_sites.index')->with('success', 'Asset Site updated successfully!');
    }

    public function destroy(AssetSite $assetSite)
    {
        $assetSite->delete();

        return redirect()->route('asset_sites.index')->with('success', 'Asset Site deleted successfully!');
    }
}