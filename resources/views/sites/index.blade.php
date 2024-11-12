@extends('adminlte::page')
@section('title', 'Sites')
@section('content_header')
    <h1>Sites</h1>
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
    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('sites.create') }}" class="btn btn-primary">Add Site</a>
        <form action="{{ route('sites.index') }}" method="GET" class="form-inline">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search sites..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Number</th>
                <th>Name</th>
                <th>Customer</th>
                <th>Note</th>
                <th>Note 2</th>
                <th>Note 3</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sites as $site)
                <tr>
                    <td>{{ $site->id }}</td>
                    <td>{{ $site->number }}</td>
                    <td>{{ $site->name }}</td>
                    <td>{{ $site->customer->name ?? 'N/A' }}</td>
                    <td>{{ $site->note }}</td>
                    <td>{{ $site->note2 }}</td>
                    <td>{{ $site->note3 }}</td>
                    <td>
                        @include('partials.actions', ['model' => $site, 'resource' => 'sites'])
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $sites->links() }} <!-- Pagination links -->
@stop