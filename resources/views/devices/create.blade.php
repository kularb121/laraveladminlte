@extends('adminlte::page')

@section('title', 'Add Device')

@section('content_header')
    <h1>Add Device</h1>
@stop

@section('content')
    <form action="{{ route('devices.store') }}" method="POST"> 
        @csrf 
        <div class="form-group">
            <label for="number">Number:</label>
            <input type="text" name="number" id="number" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="status_id">Status:</label>
            <select name="status_id" id="status_id" class="form-control">
                @foreach ($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="mobile_number">Mobile Number:</label>
            <input type="text" name="mobile_number" id="mobile_number" class="form-control">
        </div>
        <div class="form-group">
            <label for="manu_date">Manufacture Date:</label>
            <input type="date" name="manu_date" id="manu_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="customer_id">Customer:</label>
            <select name="customer_id" id="customer_id" class="form-control">
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option> 
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="note">Note:</label>
            <textarea name="note" id="note" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="note2">Note 2:</label>
            <textarea name="note2" id="note2" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="note3">Note 3:</label>
            <textarea name="note3" id="note3" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@stop