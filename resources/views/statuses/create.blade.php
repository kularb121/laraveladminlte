@extends('adminlte::page')

@section('title', 'Add Status')

@section('content_header')
    <h1>Add Status</h1>
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
    <form action="{{ route('statuses.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="number">Number:</label> 
            <input type="text" name="number" id="number" class="form-control">
        </div>
        <div class="form-group">
            <label for="name">Name:</label> 

            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="note">Note:</label> 

            <textarea name="note" id="note" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@stop