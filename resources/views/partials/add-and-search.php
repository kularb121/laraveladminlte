
<div class="mb-3 d-flex justify-content-between">

    <a href="{{ route($resource . '.create') }}" class="btn btn-primary"> 
        <i class="fas fa-plus"></i> Add {{ $title }}
    </a>
    <form action="{{ route($resource . '.index') }}" method="GET" class="form-inline">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search {{ Str::plural(strtolower($title)) }}..." value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-secondary" type="submit">
                    <i class="fas fa-search"></i> 
                </button>
            </div>
        </div>
    </form>
</div>  