@extends('adminlte::page')

@section('title', 'Statuses')

@section('content_header')
    <h1>Statuses</h1>
@stop

@section('content')
    <div class="mb-3"> 
        <a href="{{ route('statuses.create') }}" class="btn btn-primary">Add Status</a>
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
@stop