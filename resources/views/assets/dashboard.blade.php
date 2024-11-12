@extends('adminlte::page')

@section('title', 'Asset Dashboard')

@section('content')
    <h2>{{ $asset->name }} Dashboard</h2>

    @foreach ($asset->devices as $device)
        <h3>Device: {{ $device->name }}</h3>
        <p>Latest Temperature: {{ $telemetryData[$device->id]['temperature'] }}</p>
        <p>Latest Humidity: {{ $telemetryData[$device->id]['humidity'] }}</p>

        <h4>Temperature History (Last 10 hours)</h4>
        <div id="temperature-chart-{{ $device->id }}"></div> 
    @endforeach

    <h3>Associated Sites</h3>
    <ul>
        @foreach ($asset->sites as $site)
            <li>{{ $site->name }}</li>
        @endforeach
    </ul>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
    <script>
        @foreach ($asset->devices as $device)
            var ctx{{ $device->id }} = document.getElementById('temperature-chart-{{ $device->id }}').getContext('2d');
            var chart{{ $device->id }} = new Chart(ctx{{ $device->id }}, {
                type: 'line',
                data: {
                    labels: {!! $telemetryData[$device->id]['temperatureHistory']->pluck('timestamp')->toJson() !!}, 
                    datasets: [{
                        label: 'Temperature',
                        data: {!! $telemetryData[$device->id]['temperatureHistory']->pluck('value')->toJson() !!}, 
                        // ... chart styling options ...
                    }]
                },
                // ... other chart options ...
            });
        @endforeach
    </script>
@endsection