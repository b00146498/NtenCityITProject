@extends('layouts.mobile')

@section('content')

<!-- Client Profile Header -->
<div class="dashboard-header">
    <img src="{{ asset('ntencitylogo.png') }}" alt="Ntencity Logo" class="logo">
    @auth
        <div class="user-info">
            {{ Auth::user()->name }} <i class="fas fa-user"></i>
        </div>
    @endauth
</div>

<!-- Client Profile Section -->
<div class="profile-container">
    <h2 class="profile-title">My Profile</h2>

    <!-- Profile Icon -->
    <div class="profile-icon">
        <i class="fas fa-user-circle"></i>
    </div>

    <!-- Profile Menu -->
    <ul class="profile-menu">
        <li>
            <a href="{{ url('/profile/history') }}">
                <i class="fas fa-history"></i> History
                <i class="fas fa-chevron-right chevron-icon"></i>
            </a>
        </li>
        <li>
            <a href="{{ url('/profile/personal-details') }}">
                <i class="fas fa-user"></i> Personal Details
                <i class="fas fa-chevron-right chevron-icon"></i>
            </a>
        </li>
        <li>
            <a href="{{ url('/profile/about') }}">
                <i class="fas fa-info-circle"></i> About
                <i class="fas fa-chevron-right chevron-icon"></i>
            </a>
        </li>
        <li>
            <a href="{{ url('/profile/help') }}">
                <i class="fas fa-question-circle"></i> Help
                <i class="fas fa-chevron-right chevron-icon"></i>
            </a>
        </li>
        <li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit">
                    <i class="fas fa-sign-out-alt"></i> Log out
                    <i class="fas fa-chevron-right chevron-icon"></i>
                </button>
            </form>
        </li>
    </ul>
</div>

<!-- Bottom Navigation -->
<nav class="bottom-nav">
    <a href="{{ url('/client/clientdashboard') }}" class="nav-item"><i class="fas fa-home"></i></a>
    <a href="{{ url('/progress') }}" class="nav-item"><i class="fas fa-list"></i></a>
    <a href="{{ url('/appointments') }}" class="nav-item"><i class="fas fa-clock"></i></a>
    <a href="{{ url('/workoutlogs') }}" class="nav-item"><i class="far fa-check-circle"></i></a>
    <a href="#" class="nav-item"><i class="fas fa-comment"></i></a>
    <a href="{{ url('/clientprofile') }}" class="nav-item active"><i class="fas fa-user"></i></a>
</nav>

@endsection

<!-- Profile Styles -->
<style>
    .profile-container {
        text-align: center;
        margin-top: 20px;
    }

    .profile-title {
        font-size: 24px;
        font-weight: bold;
        color: #000;
    }

    .profile-icon {
        font-size: 60px;
        color: #333;
        margin: 15px 0;
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

    .nav-item {
        text-align: center;
        font-size: 14px;
        color: black;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: bold;
    }

    .nav-item i {
        font-size: 20px;
        margin-bottom: 3px;
    }

    /* Dashboard Header */
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


    .profile-menu {
    list-style: none;
    padding: 0;
    margin: 0;
    }

    .profile-menu li {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 15px;
    border-bottom: 1px solid #ddd;
    }

    /* Make sure last item doesn't have a border */
    .profile-menu li:last-child {
        border-bottom: none;
    }

    /* Standard styling for links and buttons */
    .profile-menu a,
    .logout-button {
        display: flex;
        align-items: center;
        justify-content: space-between; /* Ensures icon and text align properly */
        width: 100%;
        text-decoration: none;
        color: #333;
        font-size: 16px;
        font-weight: 500;
        padding: 12px 15px; /* Adjust padding to be the same for all items */
        background: none;
        border: none;
        cursor: pointer;
        text-align: left;
    }

    /* Fix Logout Form Styling */
    .logout-form {
        width: 100%;
        margin: 0;
        padding: 0;
    }

    /* Ensure the button behaves like an anchor tag */
    .logout-button {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-align: left;
        background: none;
        border: none;
        padding: 12px 15px; /* Matches other menu items */
    }

    /* Make icons align consistently */
    .profile-menu i {
        margin-right: 12px;
        font-size: 18px;
    }

    /* Adjust Chevron Icon */
    .chevron-icon {
        margin-left: auto;
        font-size: 14px;
        color: #888;
    }

    /* Hover effect for all menu items */
    .profile-menu a:hover,
    .logout-button:hover {
        color: #C96E04;
    }

    
</style>
