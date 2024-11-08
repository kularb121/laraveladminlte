@extends('adminlte::page')

@section('title', 'Devices')

@section('content_header')
    <h1>Devices</h1>
@stop

@section('content')
    <div class="mb-3">
        <a href="{{ route('devices.create') }}" class="btn btn-primary">Add Device</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Manufacture Date</th>
                <th>Status</th>
                <th>Note</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($devices as $device)
                <tr>
                    <td>{{ $device->id }}</td>
                    <td>{{ $device->name }}</td>
                    <td>{{ $device->manu_date }}</td>
                    <td>{{ $device->status->name ?? 'N/A' }}</td>
                    <td>{{ $device->note }}</td>
                    <td>
                        <a href="{{ route('devices.edit', $device->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('devices.destroy', $device->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this device?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop