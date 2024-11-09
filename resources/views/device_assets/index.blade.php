@extends('adminlte::page')

@section('title', 'Device Assets')

@section('content_header')
    <h1>Device Assets</h1>
@stop

@section('content')
    <div class="mb-3"> 
        <a href="{{ route('device_assets.create') }}" class="btn btn-primary">Add Device Asset</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Device</th>
                <th>Asset</th>
                <th>Start Date</th>
                <th>Stop Date</th>
                <th>Status</th>
                <th>Note</th>
                <th>Note 2</th>
                <th>Note 3</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($device_assets as $device_asset)
                <tr>
                    <td>{{ $device_asset->id }}</td>
                    <td>{{ $device_asset->device->number }}</td> 
                    <td>{{ $device_asset->asset->name }}</td> 
                    <td>{{ $device_asset->start_date }}</td>
                    <td>{{ $device_asset->stop_date }}</td>
                    <td>{{ $device_asset->status->name }}</td> 
                    <td>{{ $device_asset->note }}</td>
                    <td>{{ $device_asset->note2 }}</td>
                    <td>{{ $device_asset->note3 }}</td>
                    <td>
                        <a href="{{ route('device_assets.edit', $device_asset->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit 
                        </a>
                        <form action="{{ route('device_assets.destroy', $device_asset->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this device asset?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop