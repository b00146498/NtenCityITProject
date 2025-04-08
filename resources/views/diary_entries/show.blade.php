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

@if($polyline)
    <div class="map-box mt-4">
        <h4 class="mb-3">📍 Activity Route Map</h4>
        <div id="activityMap"></div>
    </div>
@endif

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
<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Polyline Decoder -->
<script src="https://unpkg.com/@mapbox/polyline"></script>

@if($polyline)
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const encoded = @json($polyline);
        const coords = L.Polyline.fromEncoded(encoded).getLatLngs();

        const map = L.map('activityMap').setView(coords[0], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const route = L.polyline(coords, {
            color: '#C96E04',
            weight: 5,
            opacity: 0.8,
            lineJoin: 'round'
        }).addTo(map);

        map.fitBounds(route.getBounds());
    });
</script>
@endif

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
    #activityMap {
        height: 300px;
        width: 100%;
        border-radius: 10px;
        border: 2px solid #C96E04;
        z-index: 0;
    }

    .map-box {
        background: none;
        padding: 0;
        box-shadow: none;
        border: none;
    }
</style>
@endsection
