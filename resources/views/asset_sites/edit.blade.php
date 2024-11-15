@extends('adminlte::page')

@section('title', 'Edit Asset Site')

@section('content_header')
    <h1>Edit Asset Site</h1>
@stop

@section('content')
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('asset_sites.update', $assetSite->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="asset_id">Asset:</label>
            <select name="asset_id" id="asset_id" class="form-control" required>
                @foreach ($assets as $asset)
                    <option value="{{ $asset->id }}" {{ $assetSite->asset_id == $asset->id ? 'selected' : '' }}>{{ $asset->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="site_id">Site:</label>
            <select name="site_id" id="site_id" class="form-control" required>
                @foreach ($sites as $site)
                    <option value="{{ $site->id }}" {{ $assetSite->site_id == $site->id ? 'selected' : '' }}>{{ $site->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $assetSite->start_date }}">
        </div>
        <div class="form-group">
            <label for="stop_date">Stop Date:</label>
            <input type="date" name="stop_date" id="stop_date" class="form-control" value="{{ $assetSite->stop_date }}">
        </div>
        <div class="form-group">
            <label for="status_id">Status:</label>
            <select name="status_id" id="status_id" class="form-control">
                @foreach ($statuses as $status)
                    <option value="{{ $status->id }}" {{ $assetSite->status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="note">Note:</label>
            <textarea name="note" id="note" class="form-control">{{ $assetSite->note }}</textarea>
        </div>
        <div class="form-group">
            <label for="note2">Note 2:</label>
            <textarea name="note2" id="note2" class="form-control">{{ $assetSite->note2 }}</textarea>
        </div>
        <div class="form-group">
            <label for="note3">Note 3:</label>
            <textarea name="note3" id="note3" class="form-control">{{ $assetSite->note3 }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@stop