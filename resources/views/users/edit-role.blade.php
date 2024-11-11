@extends('adminlte::page')

@section('title', 'Edit User Role')

@section('content_header')
    <h1>Edit User Role</h1>
@stop

@section('content')
    <form action="{{ route('users.updateRole', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Role for {{ $user->name }}</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="role_id">Role:</label>
                    <select name="role_id" id="role_id" class="form-control">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update Role</button>
            </div>
        </div>
    </form>
@stop