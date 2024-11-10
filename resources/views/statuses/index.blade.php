@extends('adminlte::page')
@section('title', 'Statuses')
@section('content_header')
    <h1>Statuses</h1>
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
        <a href="{{ route('statuses.create') }}" class="btn btn-primary">Add Status</a>
        <form action="{{ route('statuses.index') }}" method="GET" class="form-inline">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search statuses..." value="{{ request('search') }}">
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
                <th>Note</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statuses as $status)
                <tr>
                    <td>{{ $status->id }}</td>
                    <td>{{ $status->number }}</td>
                    <td>{{ $status->name }}</td>
                    <td>{{ $status->note }}</td>
                    <td>
                        <a href="{{ route('statuses.edit', $status->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('statuses.destroy', $status->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this status?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $statuses->links() }} <!-- Pagination links -->
@stop