<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ntencity</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

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
            background-color: #f8f9fa; /* Light background */
            display: flex;
            align-items: center;
            padding: 0 20px;
            border-bottom: 1px solid #ddd;
        }

        .top-header img {
            height: 40px; /* Adjust logo size */
        }

        /* Sidebar styling */
        .sidebar {
            width: 250px;
            height: calc(100vh - 60px); /* Full height minus the top header */
            position: fixed;
            left: 0;
            top: 60px; /* Starts right below the top header */
            background-color: rgba(212, 175, 55, 0.39); /* Light yellowish background */
            padding-top: 20px;
        }

        .sidebar .nav-link {
            color: #54515E;
            font-weight: 500;
            padding: 10px;
            display: flex;
            align-items: center;
            border-radius: 5px; /* Small default rounding */
            transition: all 0.3s ease-in-out; /* Smooth animation */
        }

        .sidebar .nav-link:hover {
            background-color: rgba(212, 175, 55, 0.40);
            border-radius: 15px;
            padding-left: 15px;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        /* Main content styling */
        .main-content {
            margin-left: 250px; /* Same as sidebar width */
            margin-top: 60px; /* Below the top header */
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
    <nav class="sidebar d-flex flex-column">
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-home"></i> Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-calendar-alt"></i> Appointments</a></li>
            <li class="nav-item"><a class="nav-link active" href="http://localhost:8000/clients"><i class="fas fa-users"></i> Clients</a></li>
            <li class="nav-item"><a class="nav-link" href="http://localhost:8000/employees"><i class="fas fa-user-tie"></i> Employee</a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-bell"></i> Notifications</a></li>
        </ul>
        
        <!-- Bottom links (Settings, Logout) -->
        <div class="mt-auto">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-cog"></i> Settings</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="#"><i class="fas fa-sign-out-alt"></i> Log out</a></li>
            </ul>
        </div>
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
