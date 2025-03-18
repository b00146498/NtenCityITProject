@extends('layouts.mobile')

@section('content')
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <!-- Logo on the Left -->
        <img src="{{ asset('ntencitylogo.png') }}" alt="Ntencity Logo" class="logo">

        <!-- User Name on the Right -->
        @auth
            <div class="user-info">
                {{ Auth::user()->name }}<i class="fas fa-user"></i>
            </div>
        @endauth
    </div>

    <!-- Workout Logs Heading -->
    <h2 class="workout-heading">Workout Logs</h2>

    @forelse ($workoutLogs as $log)
        <div class="workout-card">
            <div class="workout-info">
                <h4>{{ $log->standardExercise->exercise_name }}</h4>
                <p><strong>Sets:</strong> {{ $log->num_sets }} | <strong>Reps:</strong> {{ $log->num_reps }}</p>
                <p><strong>Intensity:</strong> {{ $log->intensity }}</p>
                <p><strong>Duration:</strong> {{ $log->minutes }} minutes</p>
            </div>
            <input type="checkbox" class="completion-checkbox" data-id="{{ $log->id }}">
        </div>
    @empty
        <p class="no-workout">No workouts assigned yet.</p>
    @endforelse


    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
    <a href="{{ url('/client/clientdashboard') }}" class="nav-item"><i class="fas fa-home"></i></a>
        <a href="{{ url('/progress') }}" class="nav-item"><i class="fas fa-list"></i></i></a>
        <a href="{{ url('/appointments') }}" class="nav-item"><i class="fas fa-clock"></i></i></a>
        <a href="{{ url('/workoutlogs') }}" class="nav-item"><i class="far fa-check-circle"></i></a>
        <a href="#" class="nav-item"><i class="fas fa-comment"></i></a>
        <a href="#" class="nav-item"><i class="fas fa-user"></i></a>
    </nav>

@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let checkboxes = document.querySelectorAll(".completion-checkbox");

        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener("change", function () {
                let logId = this.dataset.id;
                let completed = this.checked ? 1 : 0;

                fetch(`/update-workout-log/${logId}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ completed })
                }).then(response => response.json())
                  .then(data => console.log(data.message))
                  .catch(error => console.error("Error:", error));
            });
        });
    });
</script>

<style>
    .workout-heading {
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        color: #C96E04;
        margin-top: 20px;
    }

    .workout-card {
        background: rgba(212, 175, 55, 0.15);
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .completion-checkbox {
        width: 20px;
        height: 20px;
        accent-color: #C96E04;
    }

    .no-workout {
        text-align: center;
        font-style: italic;
        color: gray;
        margin-top: 15px;
    }
    html, body {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #F3F3F3;
    overflow-x: hidden; /* Prevent horizontal scrolling */
    }

    /* Main container */
    .mobile-container {
        max-width: 350px;
        width: 100%;
        margin: auto;
        padding: 20px;
        background: white;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 15px; /* Rounded corners on all sides */
        display: flex;
        flex-direction: column;
        min-height: 100vh; /* Makes sure the page is at least full height */
        position: relative;
        overflow: hidden; /* Prevents scrollbar inside container */
    }

    /* Make content scrollable */
    .content {
        flex: 1;
        overflow-y: auto;
        padding-bottom: 80px; /* Prevents content from overlapping with bottom nav */
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* Internet Explorer/Edge */
    }

    /* Dashboard Header */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .logo {
        width: 135px;
        height: auto;
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
</style>
