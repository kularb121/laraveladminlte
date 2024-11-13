@extends('adminlte::page')

@section('title', 'Create Customer Attribute')

@section('content_header')
    <h1>Create Customer Attribute</h1>
@stop

@section('content')
    <form action="{{ route('customers.attributes.store') }}" method="POST"> 
        @csrf
        <div class="form-group">
            <label for="customer_id">Customer:</label>
            <select name="customer_id" id="customer_id" class="form-control" required>
                <option value="">Select Customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="unit">Unit:</label>
            <input type="text" name="unit" id="unit" class="form-control">
        </div>
        <div class="form-group">
            <label for="display_type">Display Type:</label>
            <select name="display_type" id="display_type" class="form-control">
                <option value="value">Value</option>
                <option value="chart">Chart</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@stop