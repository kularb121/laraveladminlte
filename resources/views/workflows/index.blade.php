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
            jsPlumb.setContainer("workflow-visualization");

            @foreach ($workflows as $workflow)
                var workflow{{ $workflow->id }} = jsPlumb.addEndpoint("workflow-{{ $workflow->id }}", { 
                    anchor: ["RightMiddle"], 
                    endpoint: ["Dot", { radius: 5 }], 
                });
            @endforeach

            // Dynamic connections (adjust based on your workflow logic)
            @foreach ($workflows as $workflow)
                @if (isset($workflow->steps) && is_array($workflow->steps))
                    @foreach ($workflow->steps as $step)
                        @if (isset($step['next']) && $step['next'])
                            jsPlumb.connect({
                                source: 'workflow-{{ $workflow->id }}-step-{{ $step["id"] }}',
                                target: 'workflow-{{ $workflow->id }}-step-{{ $step["next"] }}',
                                connector: ["Flowchart", { cornerRadius: 5 }],
                                paintStyle: { stroke: "#4CAF50", strokeWidth: 2 },
                                endpointStyle: { fill: "#4CAF50" },
                                overlays: [
                                    ["Arrow", { location: 1, width: 10, length: 10 }],
                                ],
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
            copy: function (el, source) {
                return source === document.getElementById('assignees');
            },
            accepts: function (el, target) {
                return target !== document.getElementById('assignees');
            }
        });

        drake.on('drop', function(el, target, source, sibling) {
            var workflowId = target.id.split('-')[1]; 
            var userId = el.id.split('-')[1]; 

            $.ajax({
                url: "{{ route('workflows.assign', ['workflow' => $workflow->id]) }}",
                type: 'POST',
                data: {
                    user_id: userId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    new Noty({
                        type: 'success',
                        text: 'Task assigned successfully!',
                        layout: 'topRight',
                        theme: 'relax',
                        timeout: 3000
                    }).show();
                },
                error: function(error) {
                    console.error(error);
                    new Noty({
                        type: 'error',
                        text: 'Error assigning task!',
                        layout: 'topRight',
                        theme: 'relax',
                        timeout: 3000
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
                    // Display a success notification
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        theme: 'relax',
                        text: response.message, // Use the message from the server
                        timeout: 3000
                    }).show();

                    // Optionally update the workflow status in the table
                    // ...
                },
                error: function(error) {
                    // Display an error notification
                    console.error(error);
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        theme: 'relax',
                        text: 'Error updating workflow status!', 
                        timeout: 3000
                    }).show();
                }
            });
        });
        @endforeach

        $(function () {
            $('#workflows-table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/noty@3.2.0-beta/lib/noty.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/noty@3.2.0-beta/lib/themes/relax.css"> 
    <style>
        #workflow-visualization {
            border: 1px solid #ccc;
            padding: 20px;
            min-height: 400px; 
        }

        .workflow-step {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            cursor: move;
            text-align: center; 
        }

        #assignees {
            border: 1px solid #ccc;
            padding: 20px;
            min-height: 200px;
        }

        #assignees ul {
            list-style: none;
            padding: 0;
        }

        #assignees li {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 5px;
            cursor: move;
        }
    </style>
@endsection