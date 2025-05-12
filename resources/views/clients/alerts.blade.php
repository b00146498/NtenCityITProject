@extends('layouts.mobile')

@section('content')

<!-- Dashboard Header -->
<div class="dashboard-header">
    <!-- Logo on the Left -->
    <a href="{{ url('/client/clientdashboard') }}" class="favicon-btn">
        <img src="{{ asset('ntencitylogo.png') }}" alt="Dashboard" class="favicon-img">
    </a>

    <!-- User Name on the Right -->
    @auth
        <div class="user-info">
            {{ Auth::user()->name }} <i class="fas fa-user"></i>
        </div>
    @endauth
</div>

<!-- Alerts Section -->
<div class="appointment-container">
    <h2 class="section-title">Select Date and Time</h2>

    <!-- Date Navigation -->
    <div class="date-selector">
        <button id="prev-month" class="nav-arrow">&lt;</button>
        <span id="current-month">May 2025</span>
        <button id="next-month" class="nav-arrow">&gt;</button>
    </div>

    <!-- Days Navigation with horizontal scroll and arrows -->
    <div class="days-row" style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 10px;">
        <button id="prev-days" class="days-arrow" style="font-size: 20px; padding: 4px 10px; border-radius: 6px; border: none; background: #eee; cursor: pointer;">&lt;</button>
        <div class="days-container" id="days-container" style="display: flex; gap: 8px; overflow-x: auto; max-width: 260px; scroll-behavior: smooth;"></div>
        <button id="next-days" class="days-arrow" style="font-size: 20px; padding: 4px 10px; border-radius: 6px; border: none; background: #eee; cursor: pointer;">&gt;</button>
    </div>

    <!-- Status Filter Tabs (Clickable) -->
    <div class="status-tab-row">
        <a href="{{ url('/alerts?status=confirmed') }}" class="status-btn status-upcoming{{ request('status', 'confirmed') == 'confirmed' ? ' active' : '' }}">Upcoming</a>
        <a href="{{ url('/alerts?status=completed') }}" class="status-btn status-completed{{ request('status') == 'completed' ? ' active' : '' }}">Completed</a>
        <a href="{{ url('/alerts?status=canceled') }}" class="status-btn status-cancelled{{ request('status') == 'canceled' ? ' active' : '' }}">Cancelled</a>
    </div>

    <!-- Appointment List -->
    <div class="appointment-list">
        @if($appointments->isNotEmpty())
            @foreach($appointments as $appointment)
                <div class="appointment-card">
                    <div class="appointment-info">
                        <h3>
                            @if($appointment->employee)
                                {{ $appointment->employee->emp_first_name }} {{ $appointment->employee->emp_surname }}
                            @endif
                        </h3>
                        <p><strong>Practice:</strong> {{ optional($appointment->practice)->company_name ?? 'N/A' }}</p>
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->booking_date)->format('d M, Y') }}</p>
                        <p><strong>Time:</strong> {{ $appointment->start_time }} - {{ $appointment->end_time }}</p>
                    </div>
                    <button class="view-btn" onclick="openModal({{ $appointment->id }})">View</button>
                </div>
            @endforeach
        @else
            <p class="no-appointments">No {{ request('status', 'upcoming') }} appointments.</p>
        @endif
    </div>
</div>

<!-- Appointment Modal -->
<div id="appointmentModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h3>Appointment Details</h3>
        <p><strong>Employee:</strong> <span id="modalEmployee"></span></p>
        <p><strong>Practice:</strong> <span id="modalPractice"></span></p>
        <p><strong>Date:</strong> <span id="modalDate"></span></p>
        <p><strong>Time:</strong> <span id="modalTime"></span></p>
        <button class="edit-btn">Edit</button>
        <button class="cancel-btn">Cancel</button>
    </div>
</div>

<!-- Bottom Navigation -->
<nav class="bottom-nav">
    <a href="{{ url('/client/clientdashboard') }}" class="nav-item"><i class="fas fa-home"></i></a>
    <a href="{{ url('/progress') }}" class="nav-item"><i class="fas fa-list"></i></a>
    <a href="{{ url('/appointments') }}" class="nav-item"><i class="fas fa-clock"></i></a>
    <a href="{{ url('/workoutlogs') }}" class="nav-item"><i class="far fa-check-circle"></i></a>
    <a href="{{ url('/alerts') }}" class="nav-item active"><i class="fas fa-comment"></i></a>
    <a href="{{ url('/clientprofile') }}" class="nav-item"><i class="fas fa-user"></i></a>
</nav>

<style>
/* Dashboard Header */
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.favicon-btn {
    display: flex;
    align-items: center;
    padding: 4px;
    border-radius: 8px;
    transition: background 0.2s ease;
    text-decoration: none;
}

.favicon-btn:hover {
    background-color: #f0f0f0;
}

.favicon-img {
    width: 135px;
    height: auto;
    object-fit: contain;
}

.user-info {
    display: flex;
    align-items: center;
}

.user-info i {
    font-size: 18px;
    margin-left: 10px;
}

/* Date Selector */
.date-selector {
    display: flex;
    justify-content: space-between;
    align-items: center; 
    margin: 20px 0;
}

.nav-arrow {
    font-size: 20px;
    color: #c9a86a;
    text-decoration: none;
}

.current-month {
    font-size: 18px;
    font-weight: bold;
}

/* Days Container */
.days-container {
    /* Hide scrollbar for Chrome, Safari and Opera */
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none;  /* IE and Edge */
}
.days-container::-webkit-scrollbar {
    display: none;
}

.day-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 10px;
    border-radius: 12px;
    border: 1px solid #e0e0e0;
    text-decoration: none;
    color: #333;
    min-width: 60px;
}

.day-item.active {
    background-color: #c9a86a;
    color: white;
    border-color: #c9a86a;
}

.day-name {
    font-size: 14px;
}

.day-number {
    font-size: 18px;
    font-weight: bold;
}

/* Appointment Section */
.appointment-container {
    padding: 15px;
}

.section-title {
    color: #c9a86a;
    font-size: 20px;
    font-weight: bold;
    text-align: center;
}

/* No Appointments Message */
.no-appointments {
    text-align: center;
    color: #777;
    margin-top: 20px;
}

/* Tabs */
.tab-container {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 10px;
}

.tab-btn {
    background: #c9a86a;
    border: none;
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
}

.tab-btn.active {
    background: #a8894f;
}

/* Appointment Cards */
.appointment-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.appointment-card {
    background: white;
    padding: 12px;
    border-radius: 8px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.appointment-info h3 {
    margin-top: 0;
    margin-bottom: 5px;
    color: #333;
}

.appointment-info p {
    margin: 5px 0;
    color: #555;
}

.view-btn {
    background: #c9a86a;
    border: none;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
}

.modal-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 10px;
    width: 80%;
    max-width: 400px;
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    cursor: pointer;
    color: #c9a86a;
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

.nav-item.active {
    color: #c9a86a;
}

/* Buttons */
.edit-btn, .cancel-btn {
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    color: white;
    cursor: pointer;
    margin-top: 15px;
    margin-right: 10px;
}

.edit-btn {
    background: #c9a86a;
}

.cancel-btn {
    background: #e74c3c;
}

/* Status Filter Tabs (Clickable) */
.status-tab-row {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 16px;
    margin-top: 8px;
}
.status-btn {
    color: white;
    border: none;
    padding: 7px 12px;
    font-size: 15px;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0,0,0,0.07);
    transition: background 0.2s;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    min-width: 90px;
    margin: 0;
}
.status-upcoming {
    background: #f59e42;
}
.status-completed {
    background: #34a853;
}
.status-cancelled {
    background: #e63946;
}
.status-btn.active, .status-btn:active, .status-btn:focus {
    outline: none;
    filter: brightness(0.95);
    box-shadow: 0 4px 12px rgba(0,0,0,0.10);
    border: 2px solid #fff3;
}
@media (max-width: 500px) {
    .status-btn {
        min-width: 70px;
        font-size: 14px;
        padding: 6px 6px;
    }
    .status-tab-row {
        gap: 6px;
    }
}
</style>

<script>
function openModal(id) {
    let appointment = @json($appointments);
    let selected = appointment.find(a => a.id === id);

    if (selected) {
        document.getElementById('modalEmployee').innerText = selected.employee ? selected.employee.name : 'N/A';
        document.getElementById('modalPractice').innerText = selected.practice ? selected.practice.name : 'N/A';
        document.getElementById('modalDate').innerText = new Date(selected.booking_date).toLocaleDateString();
        document.getElementById('modalTime').innerText = selected.start_time + " - " + selected.end_time;
   
        document.getElementById('appointmentModal').style.display = 'block';
    }
}

function closeModal() {
    document.getElementById('appointmentModal').style.display = 'none';
}

function renderDays(month, year) {
    const daysContainer = document.getElementById('days-container');
    daysContainer.innerHTML = '';
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    for (let dayNum = 1; dayNum <= daysInMonth; dayNum++) {
        let dateObj = new Date(year, month, dayNum);
        let dayName = dateObj.toLocaleDateString('en-US', { weekday: 'short' });
        let fullDate = dateObj.toISOString().split('T')[0];
        let isActive = (new URLSearchParams(window.location.search).get('day') === fullDate) ? 'active' : '';
        daysContainer.innerHTML += `
            <a href="/alerts?day=${fullDate}" class="day-item ${isActive}">
                <div class="day-name">${dayName}</div>
                <div class="day-number">${dayNum}</div>
            </a>
        `;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    let urlParams = new URLSearchParams(window.location.search);
    let selectedDay = urlParams.get('day');
    let initialDate = selectedDay ? new Date(selectedDay) : new Date();
    let currentMonth = initialDate.getMonth();
    let currentYear = initialDate.getFullYear();

    function updateMonthDisplay() {
        const monthNames = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        const monthSpan = document.getElementById('current-month');
        if (monthSpan) {
            monthSpan.textContent = monthNames[currentMonth] + ' ' + currentYear;
        }
        renderDays(currentMonth, currentYear);
        // Auto-scroll to selected day if present
        setTimeout(() => {
            const daysContainer = document.getElementById('days-container');
            const activeDay = daysContainer.querySelector('.day-item.active');
            if (activeDay) {
                activeDay.scrollIntoView({ inline: 'center', behavior: 'smooth', block: 'nearest' });
            }
        }, 100);
    }

    const prevBtn = document.getElementById('prev-month');
    const nextBtn = document.getElementById('next-month');
    if (prevBtn && nextBtn) {
        prevBtn.addEventListener('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            updateMonthDisplay();
        });
        nextBtn.addEventListener('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            updateMonthDisplay();
        });
    }

    // Scroll days row left/right
    document.getElementById('prev-days').addEventListener('click', function() {
        const container = document.getElementById('days-container');
        container.scrollBy({ left: -120, behavior: 'smooth' });
    });
    document.getElementById('next-days').addEventListener('click', function() {
        const container = document.getElementById('days-container');
        container.scrollBy({ left: 120, behavior: 'smooth' });
    });

    updateMonthDisplay(); // Initial display
});
</script>

@endsection