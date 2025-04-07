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

<!-- Appointment Section -->
<div class="appointment-container">
    <h2 class="section-title">Upcoming Appointments</h2>

    <!-- Tabs for Filtering -->
    <div class="tab-container">
        <button class="tab-btn active" onclick="filterAppointments('upcoming')">Upcoming</button>
        <button class="tab-btn" onclick="filterAppointments('completed')">Completed</button>
        <button class="tab-btn" onclick="filterAppointments('cancelled')">Cancelled</button>
    </div>

    <!-- Appointment List -->
    <div class="appointment-list">
        @if($appointments->isNotEmpty())
            @foreach($appointments as $appointment)
                <div class="appointment-card {{ strtolower($appointment->status) }}">
                    <div class="appointment-info">
                        <h3>{{ optional($appointment->employee)->name ?? 'N/A' }}</h3>
                        <p><strong>Practice:</strong> {{ optional($appointment->practice)->name ?? 'N/A' }}</p>
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->booking_date)->format('d M, Y') }}</p>
                        <p><strong>Time:</strong> {{ $appointment->start_time }} - {{ $appointment->end_time }}</p>
                    </div>
                    <button class="view-btn" onclick="openModal({{ $appointment->id }})">View</button>
                </div>
            @endforeach
        @else
            <p class="no-appointments">No upcoming appointments.</p>
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
    <a href="{{ url('/appointments') }}" class="nav-item active"><i class="fas fa-clock"></i></a>
    <a href="{{ url('/workoutlogs') }}" class="nav-item"><i class="far fa-check-circle"></i></a>
    <a href="{{ url('/alerts') }}" class="nav-item"><i class="fas fa-comment"></i></a>
    <a href="{{ url('/clientprofile') }}" class="nav-item"><i class="fas fa-user"></i></a>
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
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

.modal-content {
    text-align: center;
}

.close-btn {
    font-size: 20px;
    cursor: pointer;
    color: red;
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

/* Style Edit Button */
.edit-btn {
    background: #c9a86a; /* Gold */
    color: white;
    border: none;
    padding: 8px 16px;
    font-size: 14px;
    font-weight: bold;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.edit-btn:hover {
    background: #a8894f; /* Darker Gold */
}

/* Style Cancel Button */
.cancel-btn {
    background: #e63946; /* Red */
    color: white;
    border: none;
    padding: 8px 16px;
    font-size: 14px;
    font-weight: bold;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.cancel-btn:hover {
    background: #c62828; /* Darker Red */
}

</style>

<script>
function openModal(id) {
    let appointment = @json($appointments);
    let selected = appointment.find(a => a.id === id);

    if (selected) {
        document.getElementById('modalEmployee').innerText = selected.employee ? selected.employee.name : 'N/A';
        document.getElementById('modalPractice').innerText = selected.practice ? selected.practice.name : 'N/A';
        document.getElementById('modalDate').innerText = selected.booking_date;
        document.getElementById('modalTime').innerText = selected.start_time + " - " + selected.end_time;
    
        document.getElementById('appointmentModal').style.display = 'block';
    }
}

function closeModal() {
    document.getElementById('appointmentModal').style.display = 'none';
}

function filterAppointments(type) {
    let allCards = document.querySelectorAll('.appointment-card');
    allCards.forEach(card => {
        card.style.display = card.classList.contains(type) ? 'flex' : 'none';
    });
}
</script>
