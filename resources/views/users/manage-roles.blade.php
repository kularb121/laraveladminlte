@extends('adminlte::page')

@section('title', 'Manage User Roles')

@section('content')
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('users.editRole', $user) }}" class="btn btn-primary">Edit Role</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop