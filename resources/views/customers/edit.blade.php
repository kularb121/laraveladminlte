@extends('adminlte::page')

@section('title', 'Edit Customer')

@section('content_header')
    <h1>Edit Customer</h1>
@stop

@section('content')
    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="number">Number:</label>
            <input type="text" name="number" id="number" class="form-control" value="{{ $customer->number }}" required>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $customer->name }}">
        </div>
        <div class="form-group">
            <label for="note">Note:</label>
            <textarea name="note" id="note" class="form-control">{{ $customer->note }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@stop