<?php

namespace App\Http\Controllers;

use App\Models\AssetSite;
use App\Models\Asset;
use App\Models\Site;
use App\Models\Status;
use Illuminate\Http\Request;

class AssetSiteController extends Controller
{
    public function index(Request $request)
    {
        $query = AssetSite::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('asset', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('site', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('status', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhere('note', 'like', "%{$search}%")
                  ->orWhere('note2', 'like', "%{$search}%")
                  ->orWhere('note3', 'like', "%{$search}%");
        }

        $assetSites = $query->paginate(10); // Use pagination for better performance

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