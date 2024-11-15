@extends('adminlte::page')
@section('title', 'IoT Applications')
@section('content_header')
    <h1>IoT Applications</h1>
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
            <a href="{{ route('iotapplications.create') }}" class="btn btn-primary">Add IoT Application</a>
            <form action="{{ route('iotapplications.index') }}" method="GET" class="form-inline">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search IoT applications..." value="{{ request('search') }}">
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
                <th>Device Name</th>
                <th>Asset Name</th>
                <th>Start Date</th>
                <th>Stop Date</th>
                <th>Status</th>
                <th>Note</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($iotapplications as $iotapplication)
                <tr>
                    <td>{{ $iotapplication->id }}</td>
                    <td>{{ $iotapplication->device->name }}</td>
                    <td>{{ $iotapplication->asset->name }}</td>
                    <td>{{ $iotapplication->start_date }}</td>
                    <td>{{ $iotapplication->stop_date }}</td>
                    <td>{{ $iotapplication->status->name ?? 'N/A' }}</td>
                    <td>{{ $iotapplication->note }}</td>
                    <td>
                        @include('partials.actions', ['model' => $iotapplication, 'resource' => 'iotapplications'])
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $iotapplications->links() }} <!-- Pagination links -->
@stop