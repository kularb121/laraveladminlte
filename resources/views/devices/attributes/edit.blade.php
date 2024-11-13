@extends('adminlte::page')

@section('title', 'Edit Device Attribute')

@section('content_header')
    <h1>Edit Attribute</h1>
@stop

@section('content')
    <form action="{{ route('devices.attributes.update', [$device, $attribute]) }}" method="POST">
        @csrf
        @method('PUT')
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
            <select name="display_type" id="display_type" class="form-control">
                <option value="value" {{ $attribute->display_type === 'value' ? 'selected' : '' }}>Value</option>
                <option value="chart" {{ $attribute->display_type === 'chart' ? 'selected' : '' }}>Chart</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@stop