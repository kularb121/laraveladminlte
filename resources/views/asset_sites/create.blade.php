@extends('adminlte::page')

@section('title', 'Add Asset Site')

@section('content_header')
    <h1>Add Asset Site</h1>
@stop

@section('content')
    <form action="{{ route('asset_sites.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="asset_id">Asset:</label>
            <select name="asset_id" id="asset_id" class="form-control" required>
                @foreach ($assets as $asset)
                    <option value="{{ $asset->id }}">{{ $asset->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="site_id">Site:</label>
            <select name="site_id" id="site_id" class="form-control" required>
                @foreach ($sites as $site)
                    <option value="{{ $site->id }}">{{ $site->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" class="form-control">
        </div>
        <div class="form-group">
            <label for="stop_date">Stop Date:</label>
            <input type="date" name="stop_date" id="stop_date" class="form-control">
        </div>
        <div class="form-group">
            <label for="status_id">Status:</label>
            <select name="status_id" id="status_id" class="form-control">
                @foreach ($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="note">Note:</label>
            <textarea name="note" id="note" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="note2">Note 2:</label>
            <textarea name="note2" id="note2" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="note3">Note 3:</label>
            <textarea name="note3" id="note3" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@stop