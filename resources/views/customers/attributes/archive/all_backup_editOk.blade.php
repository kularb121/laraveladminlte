@extends('adminlte::page')

@section('title', 'All Customer Attributes')

@section('content_header')
    <h1>All Customer Attributes</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createAttributeModal">
                Create Attribute
            </button>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer ID</th>
                        <th>Name</th>
                        <th>Unit</th>
                        <th>Display Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customerAttributes as $attribute)
                        <tr>
                            <td>{{ $attribute->id }}</td>
                            <td>{{ $attribute->customer_id }}</td>
                            <td>{{ $attribute->name }}</td>
                            <td>{{ $attribute->unit }}</td>
                            <td>{{ $attribute->display_type }}</td>
                            <td>
                                <a href="{{ route('customers.attributes.edit', ['customer' => $attribute->customer_id, 'attribute' => $attribute->id]) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('customers.attributes.destroy', ['customer' => $attribute->customer_id, 'attribute' => $attribute->id]) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this attribute?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="createAttributeModal" tabindex="-1" role="dialog" aria-labelledby="createAttributeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAttributeModalLabel">Create Attribute</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createAttributeForm" action="" method="POST">  </form>
                        @csrf
                        <div class="form-group">
                            <label for="customer_id">Customer</label>
                            <select class="form-control" id="customer_id" name="customer_id" required>
                                <option value="">Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateFormActionAndSubmit()">Create</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
function updateFormActionAndSubmit() {

    const customerSelect = document.getElementById('customer_id');
    const selectedCustomerId = customerSelect.value;
    const createAttributeForm = document.getElementById('createAttributeForm');

    // Validate if a customer is selected
    if (selectedCustomerId === "") {
        alert("Please select a customer.");
        return; 
    }

    // Add this line to prevent default form submission:
    event.preventDefault(); 

    createAttributeForm.action = "{{ route('customers.attributes.store', ['customer' => ':customerId']) }}".replace(':customerId', selectedCustomerId);
    createAttributeForm.submit();
}
</script>
@stop