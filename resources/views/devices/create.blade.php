@extends('adminlte::page')

@section('title', 'Add Device')

@section('content_header')
    <h1>Add Device</h1>
@stop

@section('content')
    <form action="{{ route('devices.store') }}" method="POST"> 
        @csrf 
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div   
 class="form-group">
            <label for="manu_date">Manufacture   
 Date:</label>
            <input type="date" name="manu_date" id="manu_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <input type="number" name="status" id="status" class="form-control"   
 required>
        </div>
        <div class="form-group">
            <label for="note">Note:</label>
            <textarea name="note" id="note" class="form-control" required></textarea>   

        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@stop