@extends('adminlte::page')

@section('title', 'Asset Details')

@section('content_header')
    <h1>Asset Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Asset Information</h3>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $asset->id }}</p> 
            <p><strong>Number:</strong> {{ $asset->number }}</p>
            <p><strong>Name:</strong> {{ $asset->name }}</p>
            <p><strong>Status:</strong> {{ $asset->status->name }}</p> 
            <p><strong>Note:</strong> {{ $asset->note }}</p>
            <p><strong>Note 2:</strong> {{ $asset->note2 }}</p>
            <p><strong>Note 3:</strong> {{ $asset->note3 }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('assets.index') }}" class="btn btn-secondary">Back to Assets</a>
            @if (auth()->user()->hasRole('Administrator') || auth()->user()->hasRole('Manager')) 
                <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-primary">Edit</a> 
            @endif
        </div>
    </div>
@stop