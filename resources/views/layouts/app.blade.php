<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ntencity</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">


    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/@mapbox/polyline"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Leaflet Map & Polyline Decoder -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>



    <style>
        /* Top header styling */
        .top-header{
        position: fixed; /* Keeps it fixed at the top */
        top: 0; 
        left: 0;
        width: 100%; 
        height: 60px;
        display: flex;
        z-index: 1000; 
        background-color: #f8f9fa; 
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); 
        align-items: center;
        padding: 0 20px;
        border-bottom: 1px solid #ddd;
        }

        .top-header img {
            height: 40px;
        }

        /* Sidebar styling */
        .sidebar {
            width: 250px;
            height: calc(100vh - 60px);
            position: fixed;
            left: 0;
            top: 60px;
            background-color: rgba(212, 175, 55, 0.39);
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar .nav-link {
            color: #54515E;
            font-weight: 500;
            padding: 10px;
            display: flex;
            align-items: center;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(212, 175, 55, 0.40);
            border-radius: 15px;
            padding-left: 15px;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        /* Main content styling */
        .main-content {
            margin-left: 250px;
            margin-top: 60px;
            padding: 20px;
        }
        /* Custom Styling for Dropdown */
        .custom-dropdown {
            background-color: #D4AF37; /* Solid Gold */
            border-radius: 8px; /* Rounded corners */
            border: 1px solid #B8860B; /* Deeper gold border */
            padding: 5px 0; /* Inner spacing */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); /* Soft shadow */
        }

        /* Styling for Dropdown Items */
        .custom-dropdown-item {
            padding: 10px 15px;
            font-size: 16px;
            font-weight: 500;
            color: #333; /* Dark gray text */
            transition: all 0.3s ease-in-out;
        }

        /* Hover Effect */
        .custom-dropdown-item:hover {
            background-color: #B8860B; /* Rich, solid gold */
            color: white;
            border-radius: 6px;
        }

        /* Active Effect */
        .custom-dropdown-item:active {
            background-color: #8B6508; /* Even deeper gold for click */
        }

        .logo {
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
        }

        .logo:hover {
            transform: scale(1.05);
        }

    </style>
</head>

<body>

<!-- Top Header -->
<div class="top-header d-flex justify-content-between align-items-center px-3">
    <!-- Logo on the Left -->
    <a href="{{ route('dashboard') }}">
    <img src="{{ asset('ntencitylogo.png') }}" alt="Ntencity Logo" class="logo">
</a>

<!-- Search Bar -->
<div class="flex-grow-1 d-flex justify-content-center">
    <form action="{{ route('search.global') }}" method="GET" 
          class="d-flex shadow-sm border rounded px-2 py-1 bg-white"
          style="max-width: 420px; width: 100%;">
        <input type="text" name="q" 
               class="form-control border-0 bg-transparent" 
               placeholder="Search clients, employees, exercises..." 
               required>
        <button type="submit" class="btn btn-link text-dark">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

    <!-- User Profile and Name on the Right -->
    @auth
        <div class="user-info dropdown">
            <a class="dropdown-toggle text-decoration-none text-dark d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                @php
                    $employee = null;
                    $client = null;
                    if (Auth::user()->role === 'employee') {
                        $employee = App\Models\Employee::where('userid', Auth::id())->first();
                    } elseif (Auth::user()->role === 'client') {
                        $client = App\Models\Client::where('userid', Auth::id())->first();
                    }
                @endphp
                
                @if($employee && $employee->profile_picture)
                    <img src="{{ asset($employee->profile_picture) }}" alt="Profile" class="user-profile-pic">
                @elseif($client && $client->profile_picture)
                    <img src="{{ asset($client->profile_picture) }}" alt="Profile" class="user-profile-pic">
                @else
                    <div class="profile-placeholder">
                        <i class="fas fa-user" style="font-size: 14px; color: white;"></i>
                    </div>
                @endif
                {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu custom-dropdown dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item custom-dropdown-item" href="{{ route('profile') }}"><i class="fas fa-id-card me-2"></i> My Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item custom-dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    @endauth
</div>

<!-- Sidebar -->
<nav class="sidebar">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
                <i class="fas fa-home"></i> Home
            </a>
        </li>
        @auth
        <li class="nav-item dropdown">
        <a class="nav-link" href="{{ url('/calendar/display') }}">
            <i class="fas fa-calendar-alt"></i> Appointments
        </a>
</li>

        @endauth 
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="clientsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-users"></i> Clients
            </a>
            <ul class="dropdown-menu custom-dropdown" aria-labelledby="clientsDropdown">
                <li><a class="dropdown-item custom-dropdown-item" href="{{ route('clients.index') }}">View Client Profiles</a></li>
                <li><a class="dropdown-item custom-dropdown-item" href="{{ route('diary-entries.index') }}">Client Progress Notes</a></li>
                <li><a class="dropdown-item custom-dropdown-item" href="{{ route('personalisedtrainingplans.index') }}">Personalised Training Plan</a></li>
                <li><a class="dropdown-item custom-dropdown-item" href="{{ route('tpelogs.index') }}">Workout Logs</a></li>
                <li><a class="dropdown-item custom-dropdown-item" href="{{ route('standardexercises.index') }}">Standard Exercises</a></li>     
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('employees.index') ? 'active' : '' }}" href="{{ route('employees.index') }}">
                <i class="fas fa-user-tie"></i> Employee
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('notifications') ? 'active' : '' }}" href="{{ url('/notifications') }}">
                <i class="fas fa-bell"></i> Notifications
            </a>
        </li>
    </ul>
        @include('layouts.navAuth')
</nav>

<!-- Main Content -->
<div class="main-content">
    @yield('content')
</div>

<!-- Webpack mix npm generated -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="{{ asset('js/app.js') }}"></script>

@stack('js_scripts')
@stack('scripts')

</body>
</html>