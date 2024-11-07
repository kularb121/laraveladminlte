@extends('adminlte::page')

@section('title', 'Add Status')

@section('content_header')
    <h1>Add Status</h1>
@stop

@section('content')
    <form action="{{ route('statuses.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@stop