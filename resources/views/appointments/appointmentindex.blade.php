@extends('layouts.mobile')

@section('content')

<!-- Dashboard Header -->
<div class="dashboard-header">
    <!-- Logo on the Left -->
    <img src="{{ asset('ntencitylogo.png') }}" alt="Ntencity Logo" class="logo">

    <!-- User Name on the Right -->
    @auth
        <div class="user-info">
            {{ Auth::user()->name }} <i class="fas fa-user"></i>
        </div>
    @endauth
</div>

<section class="content-header">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Functional Filter Tabs -->
    <div class="tab-container">
        <a href="{{ url('/alerts?status=confirmed') }}" class="tab-btn tab-upcoming {{ request('status') == 'confirmed' || request('status') == null ? 'active' : '' }}">Upcoming</a>
        <a href="{{ url('/alerts?status=completed') }}" class="tab-btn tab-completed {{ request('status') == 'completed' ? 'active' : '' }}">Completed</a>
        <a href="{{ url('/alerts?status=canceled') }}" class="tab-btn tab-cancelled {{ request('status') == 'canceled' ? 'active' : '' }}">Cancelled</a>
    </div>
</section>

<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-body">
            @include('appointments.appointmentlist')
        </div>
    </div>
</div>

<nav class="bottom-nav">
    <a href="{{ url('/client/clientdashboard') }}" class="nav-item"><i class="fas fa-home"></i></a>
    <a href="{{ url('/progress') }}" class="nav-item"><i class="fas fa-list"></i></a>
    <a href="{{ url('/appointments') }}" class="nav-item"><i class="fas fa-clock"></i></a>
    <a href="{{ url('/workoutlogs') }}" class="nav-item"><i class="far fa-check-circle"></i></a>
    <a href="{{ url('/alerts') }}" class="nav-item"><i class="fas fa-comment"></i></a>
    <a href="{{ url('/clientprofile') }}" class="nav-item active"><i class="fas fa-user"></i></a>
</nav>

@endsection

<style>
    h1, h2, h3, h4, h5, h6 {
        font-weight: bold !important;
        font-size: 3rem !important;
    }

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

    /* Appointment Filter Tabs */
    .tab-container {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .tab-btn {
        border: none;
        color: white;
        padding: 10px 18px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        text-decoration: none;
    }

    .tab-upcoming {
        background-color: #C96E04;
    }

    .tab-completed {
        background-color: #666666;
    }

    .tab-cancelled {
        background-color: #E63946;
    }

    .tab-btn.active {
        border: 2px solid white;
        transform: translateY(-1px);
        opacity: 0.95;
    }
</style>
