@extends('layouts.mobile')

@section('content')

<!-- Dashboard Header -->
<div class="dashboard-header">
    <a href="{{ url('/client/clientdashboard') }}" class="favicon-btn">
        <img src="{{ asset('ntencitylogo.png') }}" alt="Dashboard" class="favicon-img">
    </a>
    @auth
        <div class="user-info">
            {{ Auth::user()->name }} <i class="fas fa-user"></i>
        </div>
    @endauth
</div>

<!-- Strava Activity Cards -->
@if(!empty($activities))
    <h4 class="section-title">🚴 Recent Strava Activities</h4>
    @foreach($activities as $activity)
        <div class="card-activity">
            <h5>{{ $activity['name'] }}</h5>
            <p><strong>Distance:</strong> {{ round($activity['distance'] / 1000, 2) }} km</p>
            <p><strong>Duration:</strong> {{ gmdate("H:i:s", $activity['elapsed_time']) }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($activity['start_date'])->format('d M Y') }}</p>
        </div>
    @endforeach
@else
    <p class="text-muted text-center">No recent Strava activities found.</p>
@endif

<!-- Charts Section -->
<h4 class="section-title">📈 My Progress</h4>

<div class="chart-container"><canvas id="distanceChart"></canvas></div>
<div class="chart-container"><canvas id="speedChart"></canvas></div>
<div class="chart-container"><canvas id="typeChart"></canvas></div>

<!-- Map Section - unchanged -->
@if ($polyline)
    <div id="stravaMap" style="height: 300px; margin-top: 30px; border-radius: 10px;"></div>
@endif

<!-- Bottom Nav -->
<nav class="bottom-nav">
    <a href="{{ url('/client/clientdashboard') }}" class="nav-item"><i class="fas fa-home"></i></a>
    <a href="{{ url('/progress') }}" class="nav-item"><i class="fas fa-list"></i></a>
    <a href="{{ url('/appointments') }}" class="nav-item"><i class="fas fa-clock"></i></a>
    <a href="{{ url('/workoutlogs') }}" class="nav-item"><i class="far fa-check-circle"></i></a>
    <a href="{{ url('/alerts') }}" class="nav-item"><i class="fas fa-comment"></i></a>
    <a href="{{ url('/clientprofile') }}" class="nav-item"><i class="fas fa-user"></i></a>
</nav>

<!-- Scripts -->
<script src="https://unpkg.com/@mapbox/polyline"></script>
<script>
    const dates = @json($dates);
    const distances = @json($distances);
    const speeds = @json($speeds);
    const activityTypes = @json(array_values($activityTypes));
    const activityLabels = @json(array_keys($activityTypes));

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
                    borderColor: '#C96E04',
                    backgroundColor: 'rgba(201,110,4,0.2)',
                    fill: true,
                    tension: 0.4
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

    @if ($polyline)
        const encoded = "{{ $polyline }}";
        const decoded = polyline.decode(encoded);

        const map = L.map('stravaMap').setView(decoded[0], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.polyline(decoded, {
            color: 'red',
            weight: 4,
            opacity: 0.8,
            smoothFactor: 1
        }).addTo(map);
    @endif
</script>

<style>

.section-title {
    font-size: 1.4rem;
    font-weight: bold;
    text-align: center;
    margin: 30px 0 15px;
}
.card-activity {
    background: #FFF7ED;
    border-radius: 12px;
    padding: 15px;
    margin: 15px auto;
    max-width: 340px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}
.chart-container {
    background: #fff;
    border-radius: 10px;
    padding: 15px;
    margin: 20px auto;
    width: 100%;
    max-width: 340px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}
canvas {
    width: 100% !important;
    height: 220px !important;
}
.bottom-nav {
    position: fixed;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    max-width: 350px;
    background: white;
    display: flex;
    justify-content: space-around;
    padding: 12px 0;
    border-top: 1px solid #ccc;
    border-radius: 0 0 15px 15px;
    box-shadow: 0px -2px 5px rgba(0,0,0,0.1);
    z-index: 1000;
}
.nav-item {
    text-align: center;
    font-size: 14px;
    font-weight: bold;
    color: black;
    text-decoration: none;
}
.nav-item i {
    font-size: 20px;
    margin-bottom: 3px;
}
/* Heading Styles */
h1, h2, h3, h4, h5, h6 {
        font-weight: bold !important;
        font-size: 1.5rem !important; /* Adjust size */
}

/* Dashboard Header */
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.favicon-btn {
    display: flex;
    align-items: center;
    padding: 4px;
    border-radius: 8px;
    transition: background 0.2s ease;
    text-decoration: none;
}

.favicon-btn:hover {
    background-color: #f0f0f0;
}

.favicon-img {
    width: 135px;
    height: auto;
    object-fit: contain;
}

.user-info {
    display: flex;
    align-items: center;
}

.user-info i {
    font-size: 18px;
    margin-left: 10px;
}

.exercise-container {
    text-align: Left;
    margin-top: 20px;
}

.exercise-iframe {
    width: 100%;
    max-width: 330px;
    height: 180px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
}

.no-exercise {
    text-align: center;
    font-style: italic;
    color: gray;
    margin-top: 15px;
}


.pie-chart-container canvas {
    max-width: 220px;
    max-height: 220px;
    margin: 0 auto;
    display: block;
}

#stravaMap {
    width: 100%;
    border: 2px solid #C96E04;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
</style>

@endsection