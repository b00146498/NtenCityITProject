@extends('layouts.mobile')

@section('content')

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <!-- Logo on the Left -->
        <a href="{{ url('/client/clientdashboard') }}" class="favicon-btn">
            <img src="{{ asset('ntencitylogo.png') }}" alt="Dashboard" class="favicon-img">
        </a>

        <!-- User Name on the Right -->
        @auth
            <div class="user-info">
                {{ Auth::user()->name }}<i class="fas fa-user"></i>
            </div>
        @endauth
    </div>

    @if(!empty($activities))
        <h3 class="mt-4 mb-2">🚴 Recent Strava Activities</h3>
        @foreach($activities as $activity)
            <div class="card my-3 p-3 shadow-sm">
                <h5>{{ $activity['name'] }}</h5>
                <p><strong>Distance:</strong> {{ round($activity['distance'] / 1000, 2) }} km</p>
                <p><strong>Duration:</strong> {{ gmdate("H:i:s", $activity['elapsed_time']) }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($activity['start_date'])->format('d M Y') }}</p>
            </div>
        @endforeach
    @else
        <p class="text-muted">No recent Strava activities found.</p>
    @endif

    @php
        $activities = $activities ?? [];
        $distances = $distances ?? [];
        $dates = $dates ?? [];
        $speeds = $speeds ?? [];
        $activityTypes = $activityTypes ?? [];
    @endphp

    <h2 class="progress-heading">My Progress</h2>

    <div class="chart-container">
        <canvas id="distanceChart"></canvas>
    </div>

    <div class="chart-container">
        <canvas id="speedChart"></canvas>
    </div>

    <div class="chart-container pie-chart-container">
        <canvas id="typeChart"></canvas>
    </div>

    @if ($polyline)
        <div id="stravaMap" style="height: 300px; margin-top: 30px; border-radius: 10px;"></div>
    @endif

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="{{ url('/client/clientdashboard') }}" class="nav-item"><i class="fas fa-home"></i></a>
        <a href="{{ url('/progress') }}" class="nav-item"><i class="fas fa-list"></i></i></a>
        <a href="{{ url('/appointments') }}" class="nav-item"><i class="fas fa-clock"></i></i></a>
        <a href="{{ url('/workoutlogs') }}" class="nav-item"><i class="far fa-check-circle"></i></a>
        <a href="{{ url('/alerts') }}" class="nav-item"><i class="fas fa-comment"></i></a>
        <a href="{{ url('/clientprofile') }}" class="nav-item"><i class="fas fa-user"></i></a>
    </nav>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const dates = @json($dates);
    const distances = @json($distances);
    const speeds = @json($speeds);
    const activityTypes = @json(array_values($activityTypes));
    const activityLabels = @json(array_keys($activityTypes));

    // Distance Over Time Chart
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
            }
        });
    }

    // Speed Chart
    new Chart(document.getElementById('speedChart'), {
        type: 'bar',
        data: {
            labels: dates,
            datasets: [{
                label: 'Average Speed (km/h)',
                data: speeds,
                backgroundColor: '#5B9BD5'
            }]
        }
    });

    // Activity Type Chart
    new Chart(document.getElementById('typeChart'), {
        type: 'pie',
        data: {
            labels: activityLabels,
            datasets: [{
                data: activityTypes,
                backgroundColor: ['#C96E04', '#5B9BD5', '#70AD47', '#ED7D31']
            }]
        }
    });
});
    document.addEventListener("DOMContentLoaded", function () {
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
    });
</script>


<style>
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

/* Bottom Navigation */
.bottom-nav {
    position: fixed;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    max-width: 350px; /* Matches the mobile display width */
    background: white;
    display: flex;
    justify-content: space-around;
    padding: 12px 0;
    box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
    border-top: 1px solid #ccc;
    z-index: 1000;
    border-radius: 0 0 15px 15px; /* Rounded bottom corners */
}

/* Navigation Items */
.nav-item {
    text-align: center;
    font-size: 14px;
    color: black;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    font-weight: bold;
}

/* Icons in Navbar */
.nav-item i {
    font-size: 20px;
    margin-bottom: 3px;
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
.chart-container {
    width: 100%;
    max-width: 340px;
    margin: 30px auto;
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