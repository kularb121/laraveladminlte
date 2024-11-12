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
                // ...

                // Example dynamic connections (adjust based on your workflow logic)
                @foreach ($workflows as $workflow)
                    @if (isset($workflow->steps) && is_array($workflow->steps))
                        @foreach ($workflow->steps as $step)
                            @if (isset($step['next']) && $step['next'])
                                jsPlumb.connect({
                                    source: 'workflow-{{ $workflow->id }}-step-{{ $step["id"] }}',
                                    target: 'workflow-{{ $workflow->id }}-step-{{ $step["next"] }}',
                                    // ... connector styling ...
                                });
                            @endif
                        @endforeach
                    @endif
                @endforeach
            });

        var drake = dragula([
            document.getElementById('assignees'), 
            document.getElementById('workflow-visualization') 
        ], {
            // ... Dragula configuration ...
        });

        drake.on('drop', function(el, target, source, sibling) {
    var workflowId = target.id.split('-')[1]; // Extract workflow ID
    var userId = el.id.split('-')[1]; // Extract user ID

    $.ajax({
        url: "{{ route('workflows.assign', ['workflow' => $workflow->id]) }}", // Use $workflow->id directly
        type: 'POST',
        data: {
            user_id: userId,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            // Handle success (e.g., display a success notification)
            new Noty({
                type: 'success',
                text: 'Task assigned successfully!',
                // ... other Noty options
            }).show();
        },
        error: function(error) {
            // Handle error (e.g., display an error message)
            console.error(error);
            new Noty({
                type: 'error',
                text: 'Error assigning task!',
                // ... other Noty options
            }).show();
        }
    });
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