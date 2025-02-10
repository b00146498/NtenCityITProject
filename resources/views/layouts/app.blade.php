<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ntencity</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Top header styling */
        .top-header {
            width: 100%;
            height: 60px;
            background-color: #f8f9fa;
            display: flex;
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
    </style>
</head>

<body>

<!-- Top Header -->
<div class="top-header">
    <img src="{{ asset('ntencitylogo.png') }}" alt="Ntencity Logo">
</div>

<!-- Sidebar -->
<nav class="sidebar">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                <i class="fas fa-home"></i> Home
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('appointments') ? 'active' : '' }}" href="{{ url('/appointments') }}">
                <i class="fas fa-calendar-alt"></i> Appointments
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('clients') ? 'active' : '' }}" href="{{ url('/clients') }}">
                <i class="fas fa-users"></i> Clients
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('employees') ? 'active' : '' }}" href="{{ url('/employees') }}">
                <i class="fas fa-user-tie"></i> Employee
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('notifications') ? 'active' : '' }}" href="{{ url('/notifications') }}">
                <i class="fas fa-bell"></i> Notifications
            </a>
        </li>
    </ul>

    <!-- Bottom links -->
    <ul class="nav flex-column mt-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/settings') }}">
                <i class="fas fa-cog"></i> Settings
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-danger" href="{{ route('logout') }}">
                <i class="fas fa-sign-out-alt"></i> Log out
            </a>
        </li>
    </ul>
</nav>

<!-- Main Content -->
<div class="main-content">
    @yield('content')
</div>

<!-- Webpack mix npm generated -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="{{ asset('js/app.js') }}"></script>

@stack('js_scripts')

</body>
</html>
