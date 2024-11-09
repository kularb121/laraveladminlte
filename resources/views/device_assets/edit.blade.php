@extends('adminlte::page')

@section('title', 'Edit Device Asset')

@section('content_header')
    <h1>Edit Device Asset</h1>
@stop

@section('content')
    <form action="{{ route('device_assets.update', $device_asset->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="device_id">Device:</label>
            <select name="device_id" id="device_id" class="form-control" required>
                @foreach ($devices as $device)
                    <option value="{{ $device->id }}" {{ $device_asset->device_id == $device->id ? 'selected' : '' }}>{{ $device->number }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="asset_id">Asset:</label>
            <select name="asset_id" id="asset_id" class="form-control" required>
                @foreach ($assets as $asset)
                    <option value="{{ $asset->id }}" {{ $device_asset->asset_id == $asset->id ? 'selected' : '' }}>{{ $asset->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $device_asset->start_date }}">
        </div>
        <div class="form-group">
            <label for="stop_date">Stop Date:</label>
            <input type="date" name="stop_date" id="stop_date" class="form-control" value="{{ $device_asset->stop_date }}">
        </div>
        <div class="form-group">
            <label for="status_id">Status:</label>
            <select name="status_id" id="status_id" class="form-control">
                @foreach ($statuses as $status)
                    <option value="{{ $status->id }}" {{ $device_asset->status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="note">Note:</label>
            <textarea name="note" id="note" class="form-control">{{ $device_asset->note }}</textarea>
        </div>
        <div class="form-group">
            <label for="note2">Note 2:</label>
            <textarea name="note2" id="note2" class="form-control">{{ $device_asset->note2 }}</textarea>
        </div>
        <div class="form-group">
            <label for="note3">Note 3:</label>
            <textarea name="note3" id="note3" class="form-control">{{ $device_asset->note3 }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@stop