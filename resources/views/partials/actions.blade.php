<a href="{{ route($resource . '.edit', $model) }}" class="btn btn-primary">
    <i class="fas fa-edit"></i> Edit
</a>
<form action="{{ route($resource . '.destroy', $model) }}" method="POST" style="display: inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">
        <i class="fas fa-trash"></i> Delete
    </button>
</form>