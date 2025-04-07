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
                {{ Auth::user()->name }} <i class="fas fa-user"></i>
            </div>
        @endauth
    </div>

    <!-- Workout Logs Heading -->
    <h2 class="workout-heading">To do:</h2>

    <div class="content">
    @forelse ($workoutLogs as $log)
        <div class="workout-card">
            <!-- 📅 Date Range at the top of the card -->
            @php
                $startDate = \Carbon\Carbon::parse($log->trainingPlan->start_date ?? null);
                $endDate = \Carbon\Carbon::parse($log->trainingPlan->end_date ?? null);
                $dateString = 'Dates not set';
                if ($startDate && $endDate) {
                    $dateString = $startDate->format('d');
                    if ($startDate->month !== $endDate->month || $startDate->year !== $endDate->year) {
                        $dateString .= ' ' . $startDate->format('M') . ' – ' . $endDate->format('d M Y');
                    } else {
                        $dateString .= '–' . $endDate->format('d M Y');
                    }
                }
            @endphp

            <div class="date-pill">
                📅 {{ $dateString }}
            </div>

            <div class="workout-info">
                <h3>{{ $log->standardExercise->exercise_name }}</h3>
                <p><strong>Sets:</strong> {{ $log->num_sets }} | <strong>Reps:</strong> {{ $log->num_reps }}</p>
                <p><strong>Intensity:</strong> {{ $log->intensity }}</p>
                <p><strong>Duration:</strong> {{ $log->minutes }} minutes</p>
                <p><strong>Times per Week:</strong> x{{ $log->times_per_week }}</p>
                <p><strong>Incline:</strong> {{ $log->incline }}°</p>
            </div>

            <div class="swipe-container" data-id="{{ $log->id }}" data-completed="{{ $log->completed }}">
                <div class="swipe-track">
                    <div class="swipe-thumb">➡️</div>
                    <span class="swipe-text">Slide to Complete</span>
                </div>
            </div>
        </div>
    @empty
        <p class="no-workout">No workouts assigned yet.</p>
    @endforelse

        <!-- Separated Exercise Video Section -->
        <h2 class="video-heading">Exercise Video</h2>

        @if ($workoutLogs->isNotEmpty() && !empty($workoutLogs->first()->standardExercise->exercise_video_link))
            <div class="exercise-video">
                <iframe width="100%" height="200" 
                        src="{{ $workoutLogs->first()->standardExercise->exercise_video_link }}" 
                        frameborder="0" allowfullscreen></iframe>
            </div>
        @else
            <p class="no-exercise">No exercise video available.</p>
        @endif
    </div>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="{{ url('/client/clientdashboard') }}" class="nav-item"><i class="fas fa-home"></i></a>
        <a href="{{ url('/progress') }}" class="nav-item"><i class="fas fa-list"></i></a>
        <a href="{{ url('/appointments') }}" class="nav-item"><i class="fas fa-clock"></i></a>
        <a href="{{ url('/workoutlogs') }}" class="nav-item"><i class="far fa-check-circle"></i></a>
        <a href="{{ url('/alerts') }}" class="nav-item"><i class="fas fa-comment"></i></a>
        <a href="{{ url('/clientprofile') }}" class="nav-item"><i class="fas fa-user"></i></a>
    </nav>
@endsection


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    // === CHART.JS DATA ===
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

    // === SLIDE TO COMPLETE ===
    document.querySelectorAll(".swipe-container").forEach(container => {
        const thumb = container.querySelector(".swipe-thumb");
        const track = container.querySelector(".swipe-track");
        const text = container.querySelector(".swipe-text");
        const logId = container.dataset.id;

        let isDragging = false;
        let startX = 0;
        let currentX = 0;
        let maxOffset = 0;

        thumb.addEventListener("touchstart", e => {
            isDragging = true;
            startX = e.touches[0].clientX;
            currentX = startX;
            maxOffset = track.offsetWidth - thumb.offsetWidth - 4;
        });

        thumb.addEventListener("touchmove", e => {
            if (!isDragging) return;
            currentX = e.touches[0].clientX;
            let offset = Math.min(Math.max(0, currentX - startX), maxOffset);
            thumb.style.transform = `translateX(${offset}px)`;
        });

        thumb.addEventListener("touchend", () => {
            if (!isDragging) return;
            isDragging = false;

            let offset = parseFloat(thumb.style.transform.replace("translateX(", "").replace("px)", "")) || 0;
            let threshold = maxOffset / 2;
            let isCompleted = container.dataset.completed === "1";

            if (offset >= threshold && !isCompleted) {
                thumb.style.transform = `translateX(${maxOffset}px)`;
                text.textContent = "Completed ✅";
                container.dataset.completed = "1";

                fetch(`/update-workout-log/${logId}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ completed: 1 })
                }).then(res => res.json())
                  .then(data => console.log(data.message))
                  .catch(err => console.error("Error updating completion:", err));

            } else if (offset < threshold && isCompleted) {
                thumb.style.transform = `translateX(0px)`;
                text.textContent = "Slide to Complete";
                container.dataset.completed = "0";

                fetch(`/update-workout-log/${logId}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ completed: 0 })
                }).then(res => res.json())
                  .then(data => console.log(data.message))
                  .catch(err => console.error("Error resetting completion:", err));
            } else {
                thumb.style.transform = container.dataset.completed === "1" ? `translateX(${maxOffset}px)` : `translateX(0px)`;
            }
        });
    });
});
</script>


<style>
    html, body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: #F3F3F3;
        overflow-x: hidden;
    }

    /* Main container */
    .mobile-container {
        max-width: 350px;
        width: 100%;
        margin: auto;
        padding: 20px;
        background: white;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 15px;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        position: relative;
        overflow: hidden;
    }

    /* Make content scrollable */
    .content {
        flex: 1;
        overflow-y: auto;
        padding-bottom: 80px;
        scrollbar-width: none;
        -ms-overflow-style: none;
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

    /* Workout Heading */
    .workout-heading {
        text-align: Left;
        font-size: 24px;
        font-weight: bold;
        color: #C96E04;
        margin-top: 20px;
    }

    .workout-card {
        background: rgba(212, 175, 55, 0.15);
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        padding: 15px 15px 65px; /* Extra bottom padding for swipe */
        border-radius: 10px;
        margin-bottom: 20px;
        display: flex;
        flex-direction: column; /* Stack content vertically */
        align-items: flex-start;
        position: relative;
    }

    /* Slider container */
    /* Swipe Container */
    .swipe-container {
        position: absolute;
        bottom: 15px;
        left: 15px;
        right: 15px;
        z-index: 5;
    }

    /* Swipe Track */
    .swipe-track {
        position: relative;
        width: 100%;
        height: 42px;
        background: #e0e0e0;
        border-radius: 25px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 0 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    /* Thumb (Draggable Button) */
    .swipe-thumb {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 42px;
        background-color: #C96E04;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: white;
        cursor: pointer;
        touch-action: pan-x;
        transition: background 0.3s;
        z-index: 2;
    }

    /* Swipe Text */
    .swipe-text {
        width: 100%;
        text-align: center;
        font-size: 15px;
        font-weight: bold;
        color: #555;
        z-index: 1;
        pointer-events: none;
    }

    .no-workout {
        text-align: center;
        font-style: italic;
        color: gray;
        margin-top: 15px;
    }

    /* Exercise Video Section */
    .video-heading {
        text-align: Left;
        font-size: 20px;
        font-weight: bold;
        color: #C96E04;
        margin-top: 20px;
    }

    .exercise-video {
        margin-top: 15px;
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .exercise-video iframe {
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

    /* Bottom Navigation */
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
        box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
        border-top: 1px solid #ccc;
        z-index: 1000;
        border-radius: 0 0 15px 15px;
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

    .date-pill {
        text-align: center;
        margin: 0 auto 10px auto;
        font-size: 14px;
        font-weight: 600;
        color: #333;
        background: #ffffff;
        padding: 6px 14px;
        border-radius: 20px;
        border: 1px solid #ccc;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        width: fit-content;
    }

</style>
