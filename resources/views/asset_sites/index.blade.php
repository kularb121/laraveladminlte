@extends('adminlte::page')

@section('title', 'Asset Sites')

@section('content_header')
    <h1>Asset Sites</h1>
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
            <a href="{{ route('asset_sites.create') }}" class="btn btn-primary">Add Asset Site</a>
            <form action="{{ route('asset_sites.index') }}" method="GET" class="form-inline">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search asset sites..." value="{{ request('search') }}">
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
                <th>Asset</th>
                <th>Site</th>
                <th>Start Date</th>
                <th>Stop Date</th>
                <th>Status</th>
                <th>Note</th>
                <th>Note 2</th>
                <th>Note 3</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assetSites as $assetSite)
                <tr>
                    <td>{{ $assetSite->id }}</td>
                    <td>{{ $assetSite->asset->name }}</td>
                    <td>{{ $assetSite->site->name }}</td>
                    <td>{{ $assetSite->start_date }}</td>
                    <td>{{ $assetSite->stop_date }}</td>
                    <td>{{ $assetSite->status->name }}</td> 
                    <td>{{ $assetSite->note }}</td>
                    <td>{{ $assetSite->note2 }}</td>
                    <td>{{ $assetSite->note3 }}</td>
                    <td>
                        @include('partials.actions', ['model' => $assetSite, 'resource' => 'asset_sites'])
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $assetSites->links() }} <!-- Pagination links -->
@stop