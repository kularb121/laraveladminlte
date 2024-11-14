@extends('adminlte::page')

@section('title', 'Asset Dashboard')

@section('content')
    <h2>{{ $asset->name }} Dashboard</h2>

    @if ($asset->devices->isEmpty())
        <div class="alert alert-warning">
            This asset is not linked to any device. Please contact the administrator.
        </div>
        <a href="{{ route('assets.index') }}" class="btn btn-secondary">Back</a> 
    @else
        <h3>Associated Sites</h3>
        <ul>
            @foreach ($asset->sites as $site)
                <li>{{ $site->name }}</li>
            @endforeach
        </ul>
        <div class="form-group">
            <label for="start-date">Start Date:</label>
            <input type="date" id="start-date" class="form-control" value="{{ today()->toDateString() }}">
        </div>

        <div class="form-group">
            <label for="until-date">Until Date:</label>
            <input type="date" id="until-date" class="form-control" value="{{ today()->toDateString() }}">
        </div>

        <div class="row">
            @foreach ($asset->devices as $device)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Device: {{ $device->number }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="thermo-widget">
                                <div class="thermo-body">
                                    @if (isset($telemetryData[$device->id]['temperaturePercentage']))
                                        <div class="thermo-fill" style="height: {{ $telemetryData[$device->id]['temperaturePercentage'] }}%"></div>
                                    @endif
                                </div>
                                @if (isset($telemetryData[$device->id]['temperature']))
                                    <div class="thermo-value">{{ $telemetryData[$device->id]['temperature'] }} &deg;C</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Temperature History for {{ $device->name }}</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="temperature-chart-{{ $device->id }}"></canvas>
                        </div>
                    </div>
                </div>

                <button id="download-button-{{ $device->id }}" class="btn btn-secondary">Download {{ $device->name }} Data</button>

                <script>
                    // Event listener for the "Download" button
                    $('#download-button-{{ $device->id }}').click(function() {
                        var startDate = $('#start-date').val();
                        var untilDate = $('#until-date').val();

                        if (startDate > untilDate) {
                            alert('Until date must be greater than or equal to start date.');
                            return;
                        }

                        var url = "{{ route('assets.download', ['asset' => $asset->id, 'device' => $device->id]) }}";
                        url += '?start_date=' + startDate + '&until_date=' + untilDate;

                        window.location.href = url;
                    });
                </script>
            @endforeach
        </div>

        <div class="form-group">
            <label for="time-interval">Time Interval:</label>
            <select id="time-interval" class="form-control">
                <option value="10">Last 10 hours</option>
                <option value="1">Last 1 hour</option>
                <option value="24">Last 24 hours</option>
                <option value="168">Last 7 days</option>
                <option value="720">Last 30 days</option>
            </select>
        </div> 

        <button id="update-chart-button" class="btn btn-primary">Update Chart</button>
    @endif
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Function to update the chart
        function updateChart(deviceId, hours) {
            $.ajax({
                url: '/assets/{{ $asset->id }}/dashboard/temperature-history/' + deviceId,
                type: 'GET',
                data: {
                    hours: hours
                },
                success: function(response) {
                    // Update the chart with the new data
                    var ctx = document.getElementById('temperature-chart-' + deviceId).getContext('2d');
                    if (window.chart && window.chart[deviceId]) {
                        window.chart[deviceId].destroy();
                    }
                    window.chart = window.chart || {};
                    window.chart[deviceId] = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: 'Temperature',
                                data: response.data,
                                fill: false,
                                borderColor: 'rgb(75, 192, 192)',
                                tension: 0.1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Temperature'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Time'
                                    },
                                    ticks: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

        $(document).ready(function() {
            // Initial chart rendering
            @foreach ($asset->devices as $device)
                updateChart({{ $device->id }}, 10);
            @endforeach

            // Event listener for the "Update Chart" button
            $('#update-chart-button').click(function() {
                var hours = $('#time-interval').val();
                @foreach ($asset->devices as $device)
                    updateChart({{ $device->id }}, hours);
                @endforeach
            });
        });
    </script>
@endsection

@section('css')
    <style>
        .thermo-widget {
            text-align: center;
            margin-bottom: 20px;
        }

        .thermo-body {
            width: 20px;
            height: 100px;
            background-color: #ddd;
            border-radius: 5px;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
        }

        .thermo-fill {
            background-color: #f00;
            position: absolute;
            bottom: 0;
            width: 100%;
            transition: height 0.5s ease;
        }

        .thermo-value {
            font-size: 18px;
            margin-top: 10px;
        }
    </style>
@endsection