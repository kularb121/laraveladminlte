@extends('adminlte::page')

@section('title', 'Device Attributes')

@section('content_header')
    <h1>Attributes for {{ $device->name }}</h1>
@stop

@section('content')
    <div class="mb-3">
        <a href="{{ route('devices.attributes.create', $device) }}" class="btn btn-primary">Add Attribute</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Unit</th>
                <th>Display Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attributes as $attribute)
                <tr>
                    <td>{{ $attribute->name }}</td>
                    <td>{{ $attribute->unit }}</td>
                    <td>{{ $attribute->display_type }}</td>
                    <td>
                        <a href="{{ route('devices.attributes.edit', [$device, $attribute]) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('devices.attributes.destroy', [$device, $attribute]) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop