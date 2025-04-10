@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Heading and client info -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="fw-bold mb-2">📓 View Client Progress Notes</h2>
            <p class="mt-2"><strong>Client:</strong> {{ $diaryEntry->client->first_name }} {{ $diaryEntry->client->surname }}</p>
        </div>

        <a href="{{ route('diary-entries.index', $diaryEntry->client->id) }}" class="btn btn-primary h-100 mt-1">
            <i class="fas fa-arrow-left"></i> Back to Entries
        </a>
    </div>

    <!-- Form for diary entry -->
    <form action="{{ route('diary-entries.update', $diaryEntry->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <textarea name="content" class="form-control" rows="4" required>{{ $diaryEntry->content }}</textarea>
        </div>

    </form>
    @if(!empty($activities))
        <div class="recent-strava mb-4">
            <h4 class="mb-3">🚴 Recent Strava Activities</h4>
            <div class="row">
                @foreach($activities as $activity)
                    <div class="col-md-6 mb-3">
                        <div class="activity-card p-3 rounded shadow-sm">
                            <h5 class="fw-bold mb-2">{{ $activity['name'] }}</h5>
                            <p class="mb-1"><strong>Distance:</strong> {{ round($activity['distance'] / 1000, 2) }} km</p>
                            <p class="mb-1"><strong>Duration:</strong> {{ gmdate("H:i:s", $activity['elapsed_time']) }}</p>
                            <p class="mb-0"><strong>Date:</strong> {{ \Carbon\Carbon::parse($activity['start_date'])->format('d M Y') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-muted text-center mb-4">No recent Strava activities found.</p>
    @endif

    <!-- Strava Data Charts -->
    <div class="strava-section mb-4">
        <h4 class="mb-4">📈 Strava Progress Overview</h4>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="chart-box">
                    <canvas id="distanceChart"></canvas>
                </div>
            </div>

            <div class="col-md-4">
                <div class="chart-box">
                    <canvas id="speedChart"></canvas>
                </div>
            </div>

            <div class="col-md-4">
                <div class="chart-box">
                    <canvas id="typeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    const dates = @json($dates ?? []);
    const distances = @json($distances ?? []);
    const speeds = @json($speeds ?? []);
    const activityTypes = @json(array_values($activityTypes ?? []));
    const activityLabels = @json(array_keys($activityTypes ?? []));

    const chartOptions = {
        animation: { duration: 1000, easing: 'easeOutQuart' },
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: true, position: 'bottom' } }
    };

    if (dates.length && distances.length) {
        new Chart(document.getElementById('distanceChart'), {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Distance (km)',
                    data: distances,
                    fill: true,
                    tension: 0.4,
                    borderColor: '#C96E04',
                    backgroundColor: 'rgba(201, 110, 4, 0.2)',
                }]
            },
            options: chartOptions
        });
    }

    if (dates.length && speeds.length) {
        new Chart(document.getElementById('speedChart'), {
            type: 'bar',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Avg Speed (km/h)',
                    data: speeds,
                    backgroundColor: '#5B9BD5'
                }]
            },
            options: chartOptions
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
            options: chartOptions
        });
    }
</script>


<style>
    .chart-box {
        background: #fff;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        height: 280px;
    }

    canvas {
        width: 100% !important;
        height: 220px !important;
    }

    .strava-section {
        margin-top: 40px;
        padding: 20px;
        background-color: #FFF7ED;
        border-radius: 10px;
    }

    .form-label {
        font-weight: bold;
    }

    .btn-primary {
        background-color: #C96E04;
        border: none;
    }

    .btn-primary:hover {
        background-color: #a65303;
    }

    /* Heading Styles - Larger & Consistent */
    h1, h2, h3, h4, h5, h6 {
        font-weight: 700 !important;
        line-height: 1.3;
        margin-bottom: 0.75rem;
    }

    h2 {
        font-size: 2.2rem !important;
    }

    h3 {
        font-size: 1.8rem !important;
    }

    h4 {
        font-size: 1.6rem !important;
    }

    .form-control {
        background-color: #FFF7ED !important; /* Soft Beige */
    }
    .recent-strava {
        background-color: #FFF7ED;
        padding: 20px;
        border-radius: 10px;
    }

    .activity-card {
        background: #ffffff;
        border-left: 5px solid #C96E04;
        border-radius: 8px;
        transition: box-shadow 0.3s ease;
    }

    .activity-card:hover {
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
    }

</style>
@endsection
