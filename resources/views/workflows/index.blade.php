@extends('adminlte::page')

@section('title', 'Workflows')

@section('content_header')
    <h1>Workflows</h1>
@stop

@section('content')
    <div id="workflow-visualization">
        @foreach ($workflows as $workflow)
            <div class="workflow-step" id="workflow-{{ $workflow->id }}">
                {{ $workflow->name }}
            </div>
        @endforeach
    </div>

    <div id="assignees">
        <h3>Assignees</h3>
        <ul>
            @foreach ($users as $user)
                <li id="user-{{ $user->id }}">{{ $user->name }}</li>
            @endforeach
        </ul>
    </div>

    <table id="workflows-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Assigned To</th>
                <th>Created By</th>
                <th>Actions</th> 
            </tr>
        </thead>
        <tbody>
            @foreach ($workflows as $workflow)
                <tr>
                    <td>{{ $workflow->id }}</td>
                    <td>{{ $workflow->name }}</td>
                    <td>{{ $workflow->status }}</td>
                    <td>{{ $workflow->due_date }}</td>
                    <td>{{ $workflow->assignedTo->name ?? 'N/A' }}</td>
                    <td>{{ $workflow->createdBy->name ?? 'N/A' }}</td>
                    <td>
                        <button id="update-status-button-{{ $workflow->id }}" class="btn btn-primary">Update Status</button> 
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/jsplumb@2.15.11/dist/js/jsplumb.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/noty@3.2.0-beta/lib/noty.min.js"></script>
    <script>
        jsPlumb.ready(function () {
            // ... jsPlumb initialization and connection logic ...
        });

        var drake = dragula([
            document.getElementById('assignees'), 
            document.getElementById('workflow-visualization') 
        ], {
            // ... Dragula configuration ...
        });

        drake.on('drop', function(el, target, source, sibling) {
            // ... Dragula drop event listener with AJAX call ...
        });

        // AJAX to update workflow status
        @foreach ($workflows as $workflow)
        $('#update-status-button-{{ $workflow->id }}').click(function() { 
            $.ajax({
                url: "{{ route('workflows.updateStatus', ['workflow' => $workflow->id]) }}", 
                type: 'POST',
                data: {
                    status: 'completed', 
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Handle success (e.g., display a success notification)
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        theme: 'relax',
                        text: 'Workflow status updated!',
                        timeout: 3000
                    }).show();
                },
                error: function(error) {
                    // Handle error (e.g., display an error message)
                    console.error(error);
                }
            });
        });
        @endforeach

        $(function () {
            $('#workflows-table').DataTable({
                // ... DataTables configuration ...
            });
        });
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/noty@3.2.0-beta/lib/noty.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/noty@3.2.0-beta/lib/themes/relax.css"> 
    <style>
        /* ... CSS for workflow visualization and assignees ... */
    </style>
@endsection