@extends('adminlte::page')

@section('title', 'Edit Status')

@section('content_header')
    <h1>Edit Status</h1>
@stop

@section('content')
    <form action="{{ route('statuses.update', $status->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="number">Number:</label>
            <input type="text" name="number" id="number" class="form-control" value="{{ $status->number }}" required>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $status->name }}">
        </div>
        <div class="form-group">
            <label for="note">Note:</label>
            <textarea name="note" id="note" class="form-control">{{ $status->note }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@stop