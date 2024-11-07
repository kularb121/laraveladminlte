@extends('adminlte::page')

@section('title', 'Assets')

@section('content_header')
    <h1>Assets</h1>
@stop

@section('content')
    <div class="mb-3"> 
        <a href="{{ route('assets.create') }}" class="btn btn-primary">Add Asset</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assets as $asset)
                <tr>
                    <td>{{ $asset->id }}</td>
                    <td>{{ $asset->name }}</td>
                    <td>{{ $asset->note }}</td>
                    {{-- <td>
                        <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit 
                        </a>
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
@stop