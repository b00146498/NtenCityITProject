@extends('layouts.mobile')

@section('content')

<!-- Dashboard Header -->
<div class="dashboard-header">
    <img src="{{ asset('ntencitylogo.png') }}" alt="Ntencity Logo" class="logo">
    @auth
        <div class="user-info">
            {{ Auth::user()->name }} <i class="fas fa-user"></i>
        </div>
    @endauth
</div>

<section class="content-header">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Enhanced Date Strip with Arrows -->
    <div class="date-strip-wrapper">
        <button class="arrow-btn left" onclick="scrollDateStrip(-100)">
            <i class="fas fa-chevron-left"></i>
        </button>

        <div class="date-strip" id="dateStrip">
            @for ($i = 0; $i < 7; $i++)
                @php
                    $date = \Carbon\Carbon::now()->addDays($i);
                    $isToday = $date->isToday();
                @endphp
                <button class="date-button {{ request('day') == $date->toDateString() ? 'active' : '' }} {{ $isToday ? 'today' : '' }}"
                    onclick="window.location.href='?status={{ request('status', 'confirmed') }}&day={{ $date->toDateString() }}'">
                    {{ $date->format('D') }}<br>{{ $date->format('j') }}
                </button>
            @endfor
        </div>

        <button class="arrow-btn right" onclick="scrollDateStrip(100)">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>

    <!-- Status Tabs -->
    <div class="tab-container">
        <a href="{{ url('/alerts?status=confirmed') }}" class="tab-btn tab-upcoming {{ request('status') == 'confirmed' || request('status') == null ? 'active' : '' }}">Upcoming</a>
        <a href="{{ url('/alerts?status=completed') }}" class="tab-btn tab-completed {{ request('status') == 'completed' ? 'active' : '' }}">Completed</a>
        <a href="{{ url('/alerts?status=canceled') }}" class="tab-btn tab-cancelled {{ request('status') == 'canceled' ? 'active' : '' }}">Cancelled</a>
    </div>
</section>

<div class="content">
    @include('flash::message')
    <div class="box box-primary">
        <div class="box-body">
            @include('appointments.appointmentlist')
        </div>
    </div>
</div>

<!-- Modal Structure -->
<div id="appointmentModal" class="modal-overlay">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h3 class="modal-title">Appointment Details</h3>
        <div id="modal-body">
            <!-- Filled dynamically -->
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

<!-- Scripts -->
<script>
    function openModal(appointment) {
        document.getElementById('modal-body').innerHTML = `
            <p><strong>Date:</strong> ${appointment.date}</p>
            <p><strong>Time:</strong> ${appointment.time}</p>
            <p><strong>Trainer:</strong> ${appointment.trainer}</p>
            <p><strong>Notes:</strong> ${appointment.notes || 'None'}</p>
        `;
        document.getElementById('appointmentModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('appointmentModal').style.display = 'none';
    }

    function scrollDateStrip(distance) {
        const strip = document.getElementById('dateStrip');
        strip.scrollBy({ left: distance, behavior: 'smooth' });
    }
</script>

<style>
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

    .date-strip-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin: 0 auto 20px;
        max-width: 95%;
    }

    .arrow-btn {
        background: #fff;
        border: none;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 1.1rem;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        color: #C96E04;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .arrow-btn:hover {
        background-color: #f2f2f2;
    }

    .date-strip {
        display: flex;
        overflow-x: auto;
        gap: 12px;
        flex: 1;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .date-strip::-webkit-scrollbar {
        display: none;
    }

    .date-button {
        flex: 0 0 auto;
        text-align: center;
        border: 2px solid #ddd;
        border-radius: 16px;
        padding: 10px 12px;
        background-color: white;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        min-width: 55px;
        transition: 0.3s ease;
        font-size: 0.9rem;
        color: #333;
        font-weight: 500;
    }

    .date-button:hover {
        background-color: #f3f3f3;
        transform: translateY(-1px);
    }

    .date-button.active {
        background-color: #C96E04;
        color: white;
        border-color: #C96E04;
        font-weight: bold;
    }

    .date-button.today:not(.active) {
        border-color: #C96E04;
        box-shadow: 0 0 0 2px rgba(201, 110, 4, 0.3);
    }

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
        padding: 10px 20px;
        border-radius: 30px;
        font-weight: bold;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.25s ease-in-out;
        text-decoration: none;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .tab-upcoming {
        background-color: #C96E04;
    }

    .tab-completed {
        background-color: #28a745;
    }

    .tab-cancelled {
        background-color: #E63946;
    }

    .tab-btn.active {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
        opacity: 0.95;
    }

    .tab-btn:hover {
        opacity: 0.85;
        transform: scale(1.05);
    }

    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.4);
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .modal-content {
        background: white;
        padding: 25px;
        border-radius: 12px;
        max-width: 90%;
        width: 360px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        animation: fadeIn 0.3s ease;
        position: relative;
    }

    .modal-title {
        margin-bottom: 15px;
        font-size: 1.3rem;
        color: #C96E04;
        font-weight: bold;
    }

    .close-btn {
        position: absolute;
        top: 18px;
        right: 22px;
        font-size: 1.5rem;
        color: #666;
        cursor: pointer;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
