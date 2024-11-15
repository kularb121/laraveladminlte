@extends('adminlte::page')

@section('title', 'Create Workflow')

@section('content_header')
    <h1>Create Workflow</h1>
@stop

@section('content')
    <form action="{{ route('workflows.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="assigned_to">Assign To:</label>
                    <select name="assigned_to" id="assigned_to" class="form-control select2" required>
                        <option value="">Select Assignee</option> 
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </div>
    </form>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection