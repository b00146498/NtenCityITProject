@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fw-bold">View Client Progress Notes</h2><br>

    <p><strong>Client:</strong> {{ $diaryEntry->client->first_name }} {{ $diaryEntry->client->surname }}</p>

    <div class="row">
        <!-- Left Column: Form -->
        <div class="col-md-7">
            <form action="{{ route('diary-entries.update', $diaryEntry->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <textarea name="content" class="form-control" rows="5" required>{{ $diaryEntry->content }}</textarea>
                </div>

                <div class="d-flex justify-content-start mt-3">
                    <a href="{{ route('diary-entries.index', $diaryEntry->client->id) }}" class="btn btn-primary me-3">
                        <i class="fas fa-arrow-left"></i> Back to Entries
                    </a>
                </div>
            </form>
        </div>

        <!-- Right Column: Strava Charts -->
        <div class="col-md-5">
            <h5 class="mb-4">📈 Strava Progress</h5>

            <div class="chart-box mb-4">
                <canvas id="distanceChart"></canvas>
            </div>

            <div class="chart-box mb-4">
                <canvas id="speedChart"></canvas>
            </div>

            <div class="chart-box mb-4">
                <canvas id="typeChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const dates = @json($dates ?? []);
    const distances = @json($distances ?? []);
    const speeds = @json($speeds ?? []);
    const activityTypes = @json(array_values($activityTypes ?? []));
    const activityLabels = @json(array_keys($activityTypes ?? []));

    if (dates.length && distances.length) {
        new Chart(document.getElementById('distanceChart'), {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Distance (km)',
                    data: distances,
                    fill: true,
                    tension: 0.3,
                    borderColor: '#C96E04',
                    backgroundColor: 'rgba(201, 110, 4, 0.1)',
                }]
            },
            options: {
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }


    if (dates.length && speeds.length) {
        new Chart(document.getElementById('speedChart'), {
            type: 'bar',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Average Speed (km/h)',
                    data: speeds,
                    backgroundColor: '#5B9BD5'
                }]
            },
            options: {
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    if (activityLabels.length && activityTypes.length) {
        new Chart(document.getElementById('typeChart'), {
            type: 'pie',
            data: {
                labels: activityLabels,
                datasets: [{
                    data: activityTypes,
                    backgroundColor: ['#C96E04', '#5B9BD5', '#70AD47', '#ED7D31']
                }]
            },
            options: {
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
</script>
<style>
    /* Heading Styles */
    h1, h2, h3, h4, h5, h6 {
        font-weight: bold !important;
        font-size: 2rem !important; /* Adjust size */
    }

    /* Common Button Styles  */
    .btn-primary {
        background-color: #C96E04 !important; /* Orange */
        color: white !important;
        font-weight: bold;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 15px;
        transition: 0.3s;
        text-decoration: none;
    }

    /* Hover Effect */
    .btn-primary:hover {
        background-color: #A85C03 !important; /* Darker Orange */
    }

    /* Styled Textarea */
    .form-control {
        background-color: #FFF7ED !important; /* Soft Beige */
    }

    .chart-box {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        text-align: center;
    }

    canvas {
        max-width: 100%;
        height: 200px !important;
        margin: auto;
    }
</style>
@endsection
