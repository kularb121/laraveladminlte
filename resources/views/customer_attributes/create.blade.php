@extends('adminlte::page')

@section('title', 'Create Customer Attribute')

@section('content_header')
    <h1>Create Customer Attribute</h1>
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

    <form action="{{ route('customer_attributes.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="customer_id">Customer</label>
            <select name="customer_id" class="form-control" required>
                <option value="">Select Customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="unit">Unit</label>
            <input type="text" name="unit" class="form-control" value="{{ old('unit') }}">
        </div>

        <div class="form-group">
            <label for="display_type">Display Type</label>
            <input type="text" name="display_type" class="form-control" value="{{ old('display_type', 'value') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@stop