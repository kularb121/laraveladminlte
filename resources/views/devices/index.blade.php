@extends('adminlte::page')

@section('title', 'Devices')

@section('content_header')
    <h1>Devices</h1>
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
    <div class="mb-3">
        <a href="{{ route('devices.create') }}" class="btn btn-primary">Add Device</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Number</th>
                <th>Name</th>
                <th>Status</th>
                <th>Mobile Number</th>
                <th>Manufacture Date</th>
                <th>Customer</th>
                <th>Note</th>
                <th>Note 2</th>
                <th>Note 3</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($devices as $device)
                <tr>
                    <td>{{ $device->id }}</td>
                    <td>{{ $device->number }}</td>
                    <td>{{ $device->name }}</td>
                    <td>{{ $device->status->name ?? 'N/A' }}</td>
                    <td>{{ $device->mobile_number }}</td>
                    <td>{{ $device->manu_date }}</td>
                    <td>{{ $device->customer->name ?? 'N/A' }}</td>
                    <td>{{ $device->note }}</td>
                    <td>{{ $device->note2 }}</td>
                    <td>{{ $device->note3 }}</td>
                    <td>
                        <a href="{{ route('devices.edit', $device->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('devices.destroy', $device->id) }}" method="POST" style="display: inline-block;">
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