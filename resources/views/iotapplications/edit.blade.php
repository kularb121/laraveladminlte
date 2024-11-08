@extends('adminlte::page')

@section('title', 'Edit IoT Application')

@section('content_header')
    <h1>Edit IoT Application</h1>
@stop

@section('content')
    <form action="{{ route('iotapplications.update', $iotapplication->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="device_id">Device:</label>
            <select name="device_id" id="device_id" class="form-control" required>
                @foreach ($devices as $device)
                    <option value="{{ $device->id }}" {{ $iotapplication->device_id == $device->id ? 'selected' : '' }}>{{ $device->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="asset_id">Asset:</label>
            <select name="asset_id" id="asset_id" class="form-control" required>
                @foreach ($assets as $asset)
                    <option value="{{ $asset->id }}" {{ $iotapplication->asset_id == $asset->id ? 'selected' : '' }}>{{ $asset->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" id="status" class="form-control" required>
                @foreach ($statuses as $status)
                    <option value="{{ $status->id }}" {{ $iotapplication->status == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $iotapplication->start_date }}" required>
        </div>
        <div class="form-group">
            <label for="stop_date">Stop Date:</label>
            <input type="date" name="stop_date" id="stop_date" class="form-control" value="{{ $iotapplication->stop_date }}" required>
        </div>
        <div class="form-group">
            <label for="note">Note:</label>
            <textarea name="note" id="note" class="form-control">{{ $iotapplication->note }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@stop