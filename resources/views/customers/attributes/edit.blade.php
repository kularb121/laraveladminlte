@extends('adminlte::page')

@section('title', 'Edit Customer Attribute')

@section('content_header')
    <h1>Edit Customer Attribute</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('customers.attributes.update', ['customer' => $customer->id, 'attribute' => $attribute->id]) }}" method="POST">
                @csrf
                @method('PUT') 
                <div class="form-group">
                    <label for="customer_id">Customer ID:</label>
                    <input type="text" name="customer_id" id="customer_id" class="form-control" value="{{ $attribute->customer_id }}" required>
                </div>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $attribute->name }}" required>
                </div>
                <div class="form-group">
                    <label for="unit">Unit:</label>
                    <input type="text" name="unit" id="unit" class="form-control" value="{{ $attribute->unit }}">
                </div>
                <div class="form-group">
                    <label for="display_type">Display Type:</label>
                    <select name="display_type" id="display_type" class="form-control" required>
                        <option value="value" @if ($attribute->display_type == 'value') selected @endif>value</option>
                        <option value="chart" @if ($attribute->display_type == 'chart') selected @endif>chart</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@stop