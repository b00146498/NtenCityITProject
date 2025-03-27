<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ntencity</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Bootstrap or any CSS framework -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Bootstrap 5 CDN (CSS + JS) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #F3F3F3; /* Light grey background */
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        /* Mobile Frame */
        .mobile-container {
            width: 100%;
            max-width: 380px; /* Increase this value to make it bigger */
            min-width: 380px; /* Ensures it doesn't get too small */
            margin: auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Header */
        .mobile-header {
            text-align: center;
            font-weight: bold;
            font-size: 1.5rem;
            padding: 10px;
            border-bottom: 2px solid #ccc;
        }

        /* Form */
        .form-group {
            margin-bottom: 15px;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn-primary {
            background: #C96E04;
            color: white;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }
        .btn-primary:hover {
            background: #A85C03;
        }

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            max-width: 380px;
            min-width: 380px;
            background: white;
            display: flex;
            justify-content: space-around;
            padding: 10px;
            box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
        }

        .nav-item {
            text-align: center;
            font-size: 14px;
            color: black;
            text-decoration: none;
        }

        .nav-item i {
            font-size: 20px;
            display: block;
        }

        /* Ensure content does not go under the navbar */
        .content {
            padding-bottom: 70px;
        }
    </style>
</head>
<body>

    <div class="mobile-container">
        <div class="content">
            @yield('content')
        </div>

        <!-- Bottom Navigation 
        <nav class="bottom-nav">
            <a href="#" class="nav-item"><i class="fas fa-home"></i> Home</a>
            <a href="#" class="nav-item"><i class="fas fa-calendar"></i> Appointments</a>
            <a href="#" class="nav-item"><i class="fas fa-user"></i> Profile</a>
            <a href="#" class="nav-item"><i class="fas fa-cog"></i> Settings</a>
        </nav>-->
    </div>

</body>
</html>
