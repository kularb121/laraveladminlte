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
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statuses as $status)
                <tr>
                    <td>{{ $status->id }}</td>
                    <td>{{ $status->name }}</td>
                    {{-- <td>
                        <a href="{{ route('statuses.edit', $asset->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit 
                        </a>
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
@stop