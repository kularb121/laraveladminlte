@extends('adminlte::page')
@section('title', 'Assets')
@section('content_header')
    <h1>Assets</h1>
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
        <a href="{{ route('assets.create') }}" class="btn btn-primary">Add Asset</a>
        <form action="{{ route('assets.index') }}" method="GET" class="form-inline">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search assets..." value="{{ request('search') }}">
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
                <th>Status</th>
                <th>Note</th>
                <th>Note 2</th>
                <th>Note 3</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assets as $asset)
                <tr>
                    <td>{{ $asset->id }}</td>
                    <td>{{ $asset->number }}</td>
                    <td>{{ $asset->name }}</td>
                    <td>{{ $asset->status->name ?? 'N/A' }}</td>
                    <td>{{ $asset->note }}</td>
                    <td>{{ $asset->note2 }}</td>
                    <td>{{ $asset->note3 }}</td>
                    <td>
                        <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this asset?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $assets->links() }} <!-- Pagination links -->
@stop