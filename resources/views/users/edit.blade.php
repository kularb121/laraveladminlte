@extends('adminlte::page')

@section('title', 'Edit User Role')

@section('content')
    <form action="{{ route('users.updateRole', $user) }}" method="POST">
        @csrf
        @method('PUT')

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

        <button type="submit" class="btn btn-primary">Update Role</button>
    </form>
@stop