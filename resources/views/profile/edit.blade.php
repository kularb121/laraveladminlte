@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Profile</h1>
@stop

@section('content')
    @if (session('status') === 'profile-updated')
        <div class="alert alert-success">
            Profile updated successfully!
        </div>
    @endif

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <form method="post" action="{{ route('profile.destroy') }}" class="mt-4">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger">Delete Account</button>
    </form>
@stop