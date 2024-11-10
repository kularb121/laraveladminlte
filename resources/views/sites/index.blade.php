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
    <div class="mb-3"> 
        <a href="{{ route('sites.create') }}" class="btn btn-primary">Add Site</a>
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
                    <td>{{ $site->customer->name }}</td> 
                    <td>{{ $site->note }}</td>
                    <td>{{ $site->note2 }}</td>
                    <td>{{ $site->note3 }}</td>
                    <td>
                        <a href="{{ route('sites.edit', $site->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit 
                        </a>
                        <form action="{{ route('sites.destroy', $site->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this site?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop