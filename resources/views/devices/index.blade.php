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
    @if (auth()->user()->hasRole('Administrator') || auth()->user()->hasRole('Manager'))
        <div class="mb-3 d-flex justify-content-between">
            <a href="{{ route('devices.create') }}" class="btn btn-primary">Add Device</a>
            <form action="{{ route('devices.index') }}" method="GET" class="form-inline">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search devices..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif
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
                        @include('partials.actions', ['model' => $device, 'resource' => 'devices'])

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $devices->links() }} <!-- Pagination links -->
@stop