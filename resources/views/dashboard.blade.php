@extends('layouts.app')

@section('content')
<!-- Dashboard Header Row -->
<div class="d-flex justify-content-between align-items-center mb-4">

    @if ($weather)
    <div class="card shadow mb-3" style="border-left: 5px solid #C9A86A;">
        <div class="card-body">
            <h5 class="h6 fw-bold text-dark mb-3">🌤 Weather in {{ $weather['name'] }}</h5>
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
            Welcome back, {{ $employee->emp_first_name }}!
        </h2>
        <p class="text-muted mb-0">
                Role: <strong>{{ $employee->role }}</strong> | Practice: <strong>{{ $company_name }}</strong>.
        </p>
    </div>

    
    <!-- Stats Boxes -->
    <div class="d-flex gap-3 flex-wrap">
        <!-- Today’s Date -->
        <div class="bg-light p-3 rounded shadow-sm d-flex align-items-center position-relative stat-box-hover">
            <i class="fas fa-calendar-day text-primary me-2 fs-5"></i>
            <div class="d-flex flex-column">
                <span class="fw-bold text-muted">Today</span>
                <span class="fw-bold">{{ now()->format('d/m/Y') }}</span>
            </div>

            <!-- Hidden Flatpickr calendar -->
            <div class="calendar-container" id="calendarContainer">
                <input type="text" id="miniCalendar" class="form-control" style="opacity: 0; height: 0; pointer-events: none;">
            </div>
        </div>

        <!-- Upcoming Appointments with hover -->
        <div class="bg-light p-3 rounded shadow-sm d-flex align-items-center position-relative stat-box-hover">
            <i class="fas fa-clock text-success me-2 fs-5"></i>
            <div class="d-flex flex-column">
                <span class="fw-bold text-muted">Appointments</span>
                <span class="fw-bold">{{ $appointments->count() }} Upcoming</span>
            </div>

            <!-- Hover Box -->
            <div class="stat-preview">
                @forelse ($appointments->take(3) as $appt)
                    <div class="stat-preview-item">
                        <div><strong>{{ $appt->client->name ?? 'Unnamed' }}</strong></div>
                        <small>{{ \Carbon\Carbon::parse($appt->start_time)->format('d M Y, H:i') }}</small>
                    </div>
                @empty
                    <div class="stat-preview-item text-muted">No upcoming appointments</div>
                @endforelse

                @if ($appointments->count() > 3)
                    <div class="text-center p-2">
                        <a href="{{ route('appointments.index') }}" class="text-decoration-none">View All</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Active Clients with hover -->
        <div class="bg-light p-3 rounded shadow-sm d-flex align-items-center position-relative stat-box-hover">
            <i class="fas fa-user-friends text-warning me-2 fs-5"></i>
            <div class="d-flex flex-column">
                <span class="fw-bold text-muted">Clients</span>
                <span class="fw-bold">{{ $activeClients }} Active</span>
            </div>

            <!-- Hover Preview -->
            <div class="stat-preview">
                @forelse ($clients->take(3) as $client)
                    <div class="stat-preview-item">
                        <strong>{{ $client->first_name ?? 'Unnamed' }}</strong>
                        <small class="d-block text-muted">Joined: {{ \Carbon\Carbon::parse($client->created_at)->format('d M Y') }}</small>
                    </div>
                @empty
                    <div class="stat-preview-item text-muted">No active clients</div>
                @endforelse

                @if ($clients->count() > 3)
                    <div class="text-center p-2">
                        <a href="{{ route('clients.index') }}" class="text-decoration-none">View All</a>
                    </div>
                @endif
            </div>
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

<!-- Quick Actions + Exercise Section -->
<div class="container my-5">
    <div class="row g-4">

        <!-- Quick Actions Left (2x2 + 2x2 stacked) -->
        <div class="col-md-6">
            <div class="row g-4">
                <!-- First 2x2 -->
                <div class="col-6">
                    <a href="{{ route('clients.create') }}" class="action-card text-center">
                        <div class="icon-circle bg-primary-subtle text-primary">
                            <img src="{{ asset('clients.png') }}" alt="Add Client" class="progress-icon">
                        </div>
                        <span class="action-text">Add Client</span>
                    </a>
                </div>

                <div class="col-6">
                    <a href="{{ route('diary-entries.index') }}" class="action-card text-center">
                        <div class="icon-circle bg-success-subtle text-success">
                            <img src="{{ asset('progress.png') }}" alt="Log Progress" class="progress-icon">
                        </div>
                        <span class="action-text">Log Progress</span>
                    </a>
                </div>

                <div class="col-6">
                    <a href="{{ route('appointments.create') }}" class="action-card text-center">
                        <div class="icon-circle bg-warning-subtle text-warning">
                            <img src="{{ asset('booking.png') }}" alt="Book Appointment" class="progress-icon">
                        </div>
                        <span class="action-text">Book Appointment</span>
                    </a>
                </div>

                <div class="col-6">
                    <a href="{{ route('personalisedTrainingPlans.create') }}" class="action-card text-center">
                        <div class="icon-circle bg-danger-subtle text-danger">
                            <img src="{{ asset('report.png') }}" alt="Create Plan" class="progress-icon">
                        </div>
                        <span class="action-text">Create Plan</span>
                    </a>
                </div>

                <!-- Second 2x2 -->
                <div class="col-6">
                    <a href="{{ route('clients.index') }}" class="action-card text-center">
                        <div class="icon-circle bg-info-subtle text-info">
                            <img src="{{ asset('clientprofile.png') }}" alt="Client Profiles" class="progress-icon">
                        </div>
                        <span class="action-text">View Client Profiles</span>
                    </a>
                </div>

                <div class="col-6">
                    <a href="{{ route('employees.index') }}" class="action-card text-center">
                        <div class="icon-circle bg-info-subtle text-info">
                            <img src="{{ asset('empprofile.png') }}" alt="Employee Profiles" class="progress-icon">
                        </div>
                        <span class="action-text">View Employee Profiles</span>
                    </a>
                </div>

                <div class="col-6">
                    <a href="{{ route('standardexercises.index') }}" class="action-card text-center">
                        <div class="icon-circle bg-info-subtle text-info">
                            <img src="{{ asset('videolink.png') }}" alt="Exercise Videos" class="progress-icon">
                        </div>
                        <span class="action-text">Exercise Videos</span>
                    </a>
                </div>

                <div class="col-6">
                    <a href="{{ route('tpelogs.index') }}" class="action-card text-center">
                        <div class="icon-circle bg-info-subtle text-info">
                            <img src="{{ asset('business-plan.png') }}" alt="Workout Plans" class="progress-icon">
                        </div>
                        <span class="action-text">Workout Plans</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Exercise of the Moment Right -->
        <div class="col-md-6 d-flex flex-column align-items-center">
    
            <!-- Search Bar -->
            <div class="w-100 mb-3" style="max-width: 420px;">
                <form action="{{ route('search.global') }}" method="GET" class="d-flex shadow-sm border rounded px-2 py-1 bg-white">
                    <input type="text" name="q" class="form-control border-0 bg-transparent" placeholder="Search clients, employees, exercises..." required>
                    <button type="submit" class="btn btn-link text-dark">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Exercise of the Moment Card -->
            @if(is_array($exercise))
                <div class="card shadow w-100" style="max-width: 420px;">
                    <div class="card-body text-center">
                        <h1 class="h4 fw-bold text-dark mb-3">🏋️ Highlighted Exercise</h1>
                        <p class="mb-1"><strong>Name:</strong> {{ ucfirst($exercise['name']) }}</p>
                        <p class="mb-1"><strong>Target:</strong> {{ $exercise['target'] }}</p>
                        <p class="mb-3"><strong>Equipment:</strong> {{ $exercise['equipment'] }}</p>
                        <div class="d-flex justify-content-center mb-3">
                            <img src="{{ $exercise['gifUrl'] }}" alt="Exercise Demo" style="max-height: 200px; max-width: 100%;" class="rounded">
                        </div>
                        <a href="{{ url()->current() }}" class="btn btn-outline-secondary btn-sm" title="Refresh">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                </div>
            @else
                <p class="text-muted mt-3">No exercise data available at the moment.</p>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendar = flatpickr("#miniCalendar", {
            inline: true,
            static: true,
            disableMobile: true,
        });

        // Show on hover
        const hoverBox = document.querySelector('.stat-box-hover');
        const calendarContainer = document.getElementById('calendarContainer');

        hoverBox.addEventListener('mouseenter', () => {
            calendarContainer.style.display = 'block';
        });

        hoverBox.addEventListener('mouseleave', () => {
            calendarContainer.style.display = 'none';
        });

        // Initially hide
        calendarContainer.style.display = 'none';
        calendarContainer.style.position = 'absolute';
        calendarContainer.style.top = '100%';
        calendarContainer.style.left = '0';
        calendarContainer.style.zIndex = '99';
        calendarContainer.style.backgroundColor = '#fff';
        calendarContainer.style.border = '1px solid #ddd';
        calendarContainer.style.borderRadius = '8px';
        calendarContainer.style.boxShadow = '0 8px 16px rgba(0,0,0,0.1)';
    });
</script>


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

    .stat-box-hover {
    position: relative;
    }

    .stat-preview {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 999;
        width: 250px;
        background-color: white;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        display: none;
        padding: 0.5rem;
    }

    .stat-box-hover:hover .stat-preview {
        display: block;
    }

    .stat-preview-item {
        padding: 0.5rem 0.75rem;
        border-bottom: 1px solid #f1f1f1;
    }

    .stat-preview-item:last-child {
        border-bottom: none;
    }
    form .btn i {
        font-size: 1.1rem;
    }
    form.d-flex input[type="text"] {
        border-radius: 0 !important;
        background-color: #FFF7ED;
        font-style: italic;
    }

    form.d-flex button {
        border-left: 1px solid #ddd;
    }

</style>

@endsection

