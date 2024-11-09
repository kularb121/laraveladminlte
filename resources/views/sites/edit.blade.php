@extends('adminlte::page')

@section('title', 'Edit Site')

@section('content_header')
    <h1>Edit Site</h1>
@stop

@section('content')
    <form action="{{ route('sites.update', $site->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="number">Number:</label>
            <input type="text" name="number" id="number" class="form-control" value="{{ $site->number }}" required>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $site->name }}">
        </div>
        <div class="form-group">
            <label for="customer_id">Customer:</label>
            <select name="customer_id" id="customer_id" class="form-control">
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" {{ $site->customer_id == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="note">Note:</label>
            <textarea name="note" id="note" class="form-control">{{ $site->note }}</textarea>
        </div>
        <div class="form-group">
            <label for="note2">Note 2:</label>
            <textarea name="note2" id="note2" class="form-control">{{ $site->note2 }}</textarea>
        </div>
        <div class="form-group">
            <label for="note3">Note 3:</label>
            <textarea name="note3" id="note3" class="form-control">{{ $site->note3 }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@stop