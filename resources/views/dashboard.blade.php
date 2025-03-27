@extends('layouts.app')

@section('content')
<!-- Dashboard Header Row -->
<div class="d-flex justify-content-between align-items-center mb-4">

    @if ($weather)
    <div class="card shadow mb-3" style="border-left: 5px solid #C9A86A;">
        <div class="card-body">
            <h5 class="card-title">🌤 Weather in {{ $weather['name'] }}</h5>
            <p>
                Temperature: <strong>{{ $weather['main']['temp'] }}°C</strong><br>
                Condition: {{ ucfirst($weather['weather'][0]['description']) }}<br>
                Wind: {{ $weather['wind']['speed'] }} m/s
            </p>
        </div>
    </div>
    @endif


    <div>
        <h2 class="h4 fw-bold text-dark mb-1">
            Welcome to your Dashboard, {{ $employee->emp_first_name }}!
        </h2>
        <p class="text-muted mb-0">
            You’re currently working as a <strong>{{ $employee->role }}</strong> at <strong>{{ $company_name }}</strong>.
        </p>
    </div>

    
    <!-- Stats Boxes -->
    <div class="d-flex gap-3">
        <div class="bg-light p-3 rounded shadow-sm d-flex align-items-center">
            <i class="fas fa-calendar-day text-primary me-2"></i>
            <span class="fw-bold">{{ now()->format('d/m/Y') }}</span>
        </div>

        <div class="bg-light p-3 rounded shadow-sm d-flex align-items-center">
            <i class="fas fa-clock text-success me-2"></i>
            <span class="fw-bold">{{ $appointments->count() }} Upcoming</span>
        </div>

        <div class="bg-light p-3 rounded shadow-sm d-flex align-items-center">
            <i class="fas fa-user-friends text-warning me-2"></i>
            <span class="fw-bold">{{ $activeClients }} Active Clients</span>
        </div>
    </div>
</div>


<div id="myCarousel" class="carousel slide mb-4 rounded shadow" data-bs-ride="carousel">
    <!-- Indicators -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2"></button>
    </div>

    <!-- Slides -->
    <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active position-relative" style="height: 350px;">
            <img src="{{ asset('dashboardimg.jpg') }}" class="d-block w-100 h-100" alt="fitness image" style="object-fit: cover; filter: brightness(70%);">
            <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
                <h1 class="display-6 fw-bold">Welcome Back, {{ Auth::user()->name }}</h1>
                <p class="lead">Let’s help clients move better today.</p>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item position-relative" style="height: 350px;">
            <img src="{{ asset('dashboardimg3.jpg') }}" class="d-block w-100 h-100" alt="fitness image" style="object-fit: cover; filter: brightness(70%);">
            <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
                <h1 class="display-6 fw-bold">Empower Progress</h1>
                <p class="lead">Your support fuels confidence, strength, and recovery.</p>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item position-relative" style="height: 350px;">
            <img src="{{ asset('dashboardimg2.jpg') }}" class="d-block w-100 h-100" alt="fitness image" style="object-fit: cover; filter: brightness(70%);">
            <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
                <h1 class="display-6 fw-bold">Every Session Counts</h1>
                <p class="lead">Great outcomes start with small, consistent actions.</p>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Quick Actions Section -->
<div class="container my-5">
    <div class="row g-4 justify-content-center">

        <!-- Add Client -->
        <div class="col-6 col-md-3">
            <a href="{{ route('clients.create') }}" class="action-card text-center">
                <div class="icon-circle bg-primary-subtle text-primary">
                    <img src="{{ asset('clients.png') }}" alt="Book" class="progress-icon">
                </div>
                <span class="action-text">Add Client</span>
            </a>
        </div>

        <!-- Log Progress -->
        <div class="col-6 col-md-3">
            <a href="{{ route('diary-entries.index') }}" class="action-card text-center">
                <div class="icon-circle bg-success-subtle text-success">
                    <img src="{{ asset('progress.png') }}" alt="Book" class="progress-icon">
                </div>
                <span class="action-text">Log Progress</span>
            </a>
        </div>

        <!-- Book Appointment -->
        <div class="col-6 col-md-3">
            <a href="{{ route('appointments.create') }}" class="action-card text-center">
                <div class="icon-circle bg-warning-subtle text-warning">
                    <img src="{{ asset('booking.png') }}" alt="Book" class="progress-icon">
                </div>
                <span class="action-text">Book Appointment</span>
            </a>
        </div>

        <!-- Create Plan -->
        <div class="col-6 col-md-3">
            <a href="{{ route('personalisedTrainingPlans.create') }}" class="action-card text-center">
                <div class="icon-circle bg-danger-subtle text-danger">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <span class="action-text">Create Plan</span>
            </a>
        </div>

    </div>
</div>
<style>
.date-box {
        background: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
    }

    .action-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-decoration: none;
        color: inherit;
        border: 1px solid #eee;
        position: relative;
        overflow: hidden;
    }

    .action-card:hover {
        transform: translateY(-8px) scale(1.03);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.15);
        text-decoration: none;
    }

    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        font-size: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        background-color: #fff8e1;
        border: 2px solid #e0c36c;
        color: #a68c30;
        transition: transform 0.4s ease;
    }

    .action-card:hover .icon-circle {
        transform: rotate(15deg) scale(1.15);
    }

    .action-text {
        font-weight: 600;
        font-size: 14px;
        color: #222;
        transition: color 0.3s ease;
    }

    .action-card:hover .action-text {
        color: #C9A86A;
    }
    .progress-icon {
        width: 42px;
        height: 42px;
        object-fit: contain;
        transition: transform 0.3s ease;
    }


</style>

@endsection

