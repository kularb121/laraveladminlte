@extends('adminlte::page')

@section('title', 'Customer Attributes')

@section('content_header')
    <h1>Customer Attributes</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('customers.attributes.create') }}" class="btn btn-primary mb-3">Create Attribute</a> 

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer ID</th>
                        <th>Name</th>
                        <th>Unit</th>
                        <th>Display Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attributes as $attribute)
                        <tr>
                            <td>{{ $attribute->id }}</td>
                            <td>{{ $attribute->customer_id }}</td>
                            <td>{{ $attribute->name }}</td>
                            <td>{{ $attribute->unit }}</td>
                            <td>{{ $attribute->display_type }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop