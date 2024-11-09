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
                <th>State Date</th>
                <th>Stop Date</th>
                <th>Status</th>
                <th>Note</th>
                <th>Note 2</th>
                <th>Note 3</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($deviceAssets as $deviceAsset)
                <tr>
                    <td>{{ $deviceAsset->id }}</td>
                    <td>{{ $deviceAsset->device->name }}</td> 
                    <td>{{ $deviceAsset->asset->name }}</td> 
                    <td>{{ $deviceAsset->state_date }}</td>
                    <td>{{ $deviceAsset->stop_date }}</td>
                    <td>{{ $deviceAsset->status_id }}</td> 
                    <td>{{ $deviceAsset->note }}</td>
                    <td>{{ $deviceAsset->note2 }}</td>
                    <td>{{ $deviceAsset->note3 }}</td>
                    <td>
                        <a href="{{ route('device_assets.edit', $deviceAsset->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit 
                        </a>
                        <form action="{{ route('device_assets.destroy', $deviceAsset->id) }}" method="POST" style="display: inline-block;">
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