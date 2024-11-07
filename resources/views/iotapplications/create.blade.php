@extends('adminlte::page')

@section('title', 'Add IoT Application')

@section('content_header')
    <h1>Add IoT Application</h1>
@stop

@section('content')
    <form action="{{ route('iotapplications.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="device_id">Device:</label>
            <select name="device_id" id="device_id" class="form-control" required>
                @foreach ($devices as $device)
                    <option value="{{ $device->id }}">{{ $device->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="asset_id">Asset:</label>
            <select name="asset_id" id="asset_id" class="form-control"   
 required>
                @foreach ($assets as $asset)
                    <option value="{{ $asset->id }}">{{ $asset->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date"   
 class="form-control" required>
        </div>
        <div class="form-group">
            <label for="stop_date">Stop   
 Date:</label>
            <input type="date" name="stop_date" id="stop_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" id="status" class="form-control"   
 required>
                @foreach ($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </div>
        <div 
 class="form-group">
            <label for="note">Note:</label>
            <textarea name="note" id="note" class="form-control"></textarea> 

        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@stop