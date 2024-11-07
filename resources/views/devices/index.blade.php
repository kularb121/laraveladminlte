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
            </tr>
        </thead>
        <tbody>
            @foreach ($devices as $device)
                <tr>
                    <td>{{ $device->id }}</td>
                    <td>{{ $device->name }}</td>
                    <td>{{ $device->manu_date }}</td>
                    <td>{{ $device->status }}</td>
                    <td>{{ $device->note }}</td>
                    {{-- <td>
                        <a href="{{ route('devices.edit', $device->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit 
                        </a>
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
@stop