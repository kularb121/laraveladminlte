@extends('adminlte::page')

@section('title', 'Customers')

@section('content_header')
    <h1>Customers</h1>
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
    @if (auth()->user()->hasRole('Administrator') || auth()->user()->hasRole('Manager'))
        <div class="mb-3 d-flex justify-content-between">
            <a href="{{ route('customers.create') }}" class="btn btn-primary">Add Customer</a>
            <form action="{{ route('customers.index') }}" method="GET" class="form-inline">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search customers..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Number</th>
                <th>Name</th>
                <th>Note</th>
                <th>Note2</th>
                <th>Note3</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->number }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->note }}</td>
                    <td>{{ $customer->note2 }}</td>
                    <td>{{ $customer->note3 }}</td>
                    <td>
                        @include('partials.actions', ['model' => $customer, 'resource' => 'customers'])
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $customers->links() }} <!-- Pagination links -->
@stop