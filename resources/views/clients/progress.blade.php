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


    <h2 class="progress-heading">My Progress</h2>
    

    



    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="{{ url('/client/clientdashboard') }}" class="nav-item"><i class="fas fa-home"></i></a>
        <a href="{{ url('/progress') }}" class="nav-item"><i class="fas fa-list"></i></i></a>
        <a href="{{ url('/appointments') }}" class="nav-item"><i class="fas fa-clock"></i></i></a>
        <a href="{{ url('/workoutlogs') }}" class="nav-item"><i class="far fa-check-circle"></i></a>
        <a href="{{ url('/alerts') }}" class="nav-item"><i class="fas fa-comment"></i></a>
        <a href="{{ url('/clientprofile') }}" class="nav-item"><i class="fas fa-user"></i></a>
    </nav>


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



</style>

@endsection