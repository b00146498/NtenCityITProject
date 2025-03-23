@extends('layouts.app')

@section('content')
<h2 class="h4 fw-bold text-dark mb-4">
    {{ __('Welcome to your Dashboard') }}
</h2>
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
            <img src="{{ asset('dashboardimg.jpg') }}" class="d-block w-100 h-100" alt="Los Angeles" style="object-fit: cover; filter: brightness(70%);">
            <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
                <h1 class="display-6 fw-bold">Welcome Back, {{ Auth::user()->name }}</h1>
                <p class="lead">Let’s help clients move better today.</p>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item position-relative" style="height: 350px;">
            <img src="{{ asset('dashboardimg3.jpg') }}" class="d-block w-100 h-100" alt="Chicago" style="object-fit: cover; filter: brightness(70%);">
            <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
                <h1 class="display-6 fw-bold">Empower Progress</h1>
                <p class="lead">Your support fuels confidence, strength, and recovery.</p>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item position-relative" style="height: 350px;">
            <img src="{{ asset('dashboardimg2.jpg') }}" class="d-block w-100 h-100" alt="New York" style="object-fit: cover; filter: brightness(70%);">
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

@endsection

