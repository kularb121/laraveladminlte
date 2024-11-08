@extends('adminlte::page')

@section('title', 'Edit Device')

@section('content_header')
    <h1>Edit Device</h1>
@stop

@section('content')
    <form action="{{ route('devices.update', $device->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $device->name }}" required>
        </div>
        <div class="form-group">
            <label for="manu_date">Manufacture Date:</label>
            <input type="date" name="manu_date" id="manu_date" class="form-control" value="{{ $device->manu_date }}" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <input type="number" name="status" id="status" class="form-control" value="{{ $device->status }}" required>
        </div>
        <div class="form-group">
            <label for="note">Note:</label>
            <textarea name="note" id="note" class="form-control">{{ $device->note }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@stop