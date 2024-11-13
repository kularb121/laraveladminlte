@extends('adminlte::page')

@section('title', 'Customer Attributes')

@section('content_header')
    <h1>Customer Attributes</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('customer_attributes.create') }}" class="btn btn-primary mb-3">Create Customer Attribute</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Name</th>
                <th>Unit</th>
                <th>Display Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customerAttributes as $attribute)
                <tr>
                    <td>{{ $attribute->id }}</td>
                    <td>{{ $attribute->customer->name }}</td>
                    <td>{{ $attribute->name }}</td>
                    <td>{{ $attribute->unit }}</td>
                    <td>{{ $attribute->display_type }}</td>
                    <td>
                        <a href="{{ route('customer_attributes.edit', $attribute->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('customer_attributes.destroy', $attribute->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop