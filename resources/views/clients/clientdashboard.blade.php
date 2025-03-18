@extends('layouts.mobile')

@section('content')

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <img src="{{ asset('images/ntencity_logo.png') }}" alt="NtenCity Logo" class="logo">
        <div class="user-info">
            <span>User Name</span>
            <i class="fas fa-user-circle"></i>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="search-container">
        <input type="text" class="search-bar" placeholder="Search">
        <i class="fas fa-search search-icon"></i>
    </div>

    <!-- List of Professionals -->
    <h3 class="section-title">List of Professionals</h3>

    <div class="professional-card">
        <div class="info">
            <h4>Dr. Andrew</h4>
            <p>MB, BS</p>
            <p>Experienced physiotherapist specializing in sports injuries.</p>
        </div>
        <button class="book-btn">Book</button>
    </div>

    <div class="professional-card">
        <div class="info">
            <h4>Dr. Julie</h4>
            <p>MB, BS</p>
            <p>10 years of experience in fitness and therapy.</p>
        </div>
        <button class="book-btn">Book</button>
    </div>

    <div class="professional-card">
        <div class="info">
            <h4>Dr. Ross</h4>
            <p>MB, BS</p>
            <p>Expert in sports medicine and rehabilitation.</p>
        </div>
        <button class="book-btn">Book</button>
    </div>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="#" class="nav-item"><i class="fas fa-home"></i> Home</a>
        <a href="#" class="nav-item"><i class="fas fa-calendar"></i> Appointments</a>
        <a href="#" class="nav-item"><i class="fas fa-user"></i> Profile</a>
        <a href="#" class="nav-item"><i class="fas fa-cog"></i> Settings</a>
    </nav>

<style>
    /* Dashboard Header */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .logo {
        width: 120px;
    }

    .user-info {
        display: flex;
        align-items: center;
        font-weight: bold;
    }

    .user-info i {
        font-size: 25px;
        margin-left: 10px;
    }

    /* Search Bar */
    .search-container {
        position: relative;
        margin-bottom: 15px;
    }

    .search-bar {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .search-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #777;
    }

    /* Professional Cards */
    .professional-card {
        background: #FFF7ED;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .book-btn {
        background: #C96E04;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
    }

    /* Bottom Navigation */
    .bottom-nav {
        position: fixed;
        bottom: 0;
        width: 100%;
        max-width: 400px;
        background: white;
        display: flex;
        justify-content: space-around;
        padding: 10px;
        box-shadow: 0px -2px 5px rgba(0,0,0,0.1);
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
</style>

@endsection
