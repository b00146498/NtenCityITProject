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

<!-- About Page Content -->
<div class="about-container">
    <h1 class="about-title">About NtenCity</h1>
    <p class="about-text">
        Welcome to <strong>NtenCity</strong>, an all-in-one client management system designed for <strong>physiotherapists and personal trainers</strong> to efficiently manage appointments, track progress, and provide video-based guidance to clients.
    </p>

    <div class="features-section">
        <h2 class="section-heading">Why Choose NtenCity?</h2>

        <div class="feature">
            <i class="fas fa-calendar-check feature-icon"></i>
            <div>
                <h3>Easy Appointments</h3>
                <p>Clients can book, reschedule, and manage their sessions anytime.</p>
            </div>
        </div>

        <div class="feature">
            <i class="fas fa-chart-line feature-icon"></i>
            <div>
                <h3>Progress Tracking</h3>
                <p>Monitor workout logs, recovery progress, and key health stats.</p>
            </div>
        </div>

        <div class="feature">
            <i class="fas fa-video feature-icon"></i>
            <div>
                <h3>Video Resources</h3>
                <p>Access exercise demonstrations and training plans for better results.</p>
            </div>
        </div>

        <div class="feature">
            <i class="fas fa-bell feature-icon"></i>
            <div>
                <h3>Smart Notifications</h3>
                <p>Get instant alerts for upcoming sessions, updates, and reminders.</p>
            </div>
        </div>

        <div class="feature">
            <i class="fas fa-lock feature-icon"></i>
            <div>
                <h3>Secure & Reliable</h3>
                <p>We ensure your data remains safe and confidential at all times.</p>
            </div>
        </div>
    </div>

    <h2 class="section-heading">Our Mission</h2>
    <p class="about-text">
        At <strong>NtenCity</strong>, we aim to simplify <strong>client-professional interactions</strong>, improve **accessibility**, and enhance **efficiency** in the health & fitness industry.
    </p>

    <h2 class="section-heading">Need Help?</h2>
    <p class="about-text">Visit our <a href="{{ url('/profile/help') }}" class="help-link">Help Section</a> or contact <a href="mailto:support@ntencity.com" class="help-link">support@ntencity.com</a>.</p>
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

<style>
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
/* Main About Page Container */
.about-container {
    padding: 20px;
    text-align: center;
}

/* Titles & Headings */
.about-title {
    font-size: 24px;
    font-weight: bold;
    color: #C96E04;
    margin-bottom: 10px;
}

.section-heading {
    font-size: 20px;
    font-weight: bold;
    margin-top: 20px;
    color: #333;
}

/* About Text */
.about-text {
    font-size: 16px;
    color: #555;
    line-height: 1.6;
    margin-bottom: 15px;
}

/* Features Section */
.features-section {
    margin-top: 20px;
}

/* Feature Item */
.feature {
    display: flex;
    align-items: center;
    background: rgba(212, 175, 55, 0.15);
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

/* Feature Icons */
.feature-icon {
    font-size: 24px;
    color: #C96E04;
    margin-right: 15px;
}

/* Help Section Links */
.help-link {
    color: #C96E04;
    font-weight: bold;
    text-decoration: none;
}

.help-link:hover {
    text-decoration: underline;
}

/* Bottom Navigation */
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

/* Active State */
.nav-item.active i {
    color: #C96E04;
}
</style>
