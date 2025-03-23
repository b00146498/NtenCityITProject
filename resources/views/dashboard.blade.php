@extends('layouts.app')

@section('content')
<!-- Dashboard Header Row -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 fw-bold text-dark mb-0">
        {{ __('Welcome to your Dashboard') }}
    </h2>
    
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
<style>
.date-box {
        background: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
    }
</style>

@endsection

