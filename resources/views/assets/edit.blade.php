@extends('adminlte::page')

@section('title', 'Edit Asset')

@section('content_header')
    <h1>Edit Asset</h1>
@stop

@section('content')
    <form action="{{ route('assets.update', $asset->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="number">Number:</label>
            <input type="text" name="number" id="number" class="form-control" value="{{ $asset->number }}" required>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $asset->name }}">
        </div>
        <div class="form-group">
            <label for="status_id">Status:</label>
            <select name="status_id" id="status_id" class="form-control">
                @foreach ($statuses as $status)
                    <option value="{{ $status->id }}" {{ $asset->status_id == $status->id ? 'selected' : '' }}>
                        {{ $status->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="note">Note:</label>
            <textarea name="note" id="note" class="form-control">{{ $asset->note }}</textarea>
        </div>
        <div class="form-group">
            <label for="note2">Note 2:</label>
            <textarea name="note2" id="note2" class="form-control">{{ $asset->note2 }}</textarea>
        </div>
        <div class="form-group">
            <label for="note3">Note 3:</label>
            <textarea name="note3" id="note3" class="form-control">{{ $asset->note3 }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@stop