@extends('layouts.mobile')

@section('content')
<!-- Calendar Header -->
<div class="dashboard-header">
    <img src="{{ asset('ntencitylogo.png') }}" alt="Ntencity Logo" class="logo">
    @auth
        <div class="user-info">
            {{ Auth::user()->name }} <i class="fas fa-user"></i>
        </div>
    @endauth
</div>

<section class="content-header">
    <h1>Select Date and Time</h1>
    
    <div class="calendar-container">
        <!-- Calendar will be loaded here -->
        <div id="calendar-view">
            <!-- This is just for display, replace with your actual calendar component -->
            <div class="month-selector">
                <button id="prev-month">&lt;</button>
                <span id="current-month">May 2025</span>
                <button id="next-month">&gt;</button>
            </div>
            
            <div class="calendar-grid">
                <!-- Calendar days will go here -->
            </div>
        </div>
    </div>
</section>

<div class="content">
    <div class="box box-primary">
        <div class="box-body">
            <h3>Available Time Slots</h3>
            <div id="time-slots-container">
                <p id="loading-message">Select a date to see available time slots.</p>
                <div id="time-slots-list" class="time-slots-grid">
                    <!-- Time slots will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<nav class="bottom-nav">
    <a href="{{ url('/client/clientdashboard') }}" class="nav-item"><i class="fas fa-home"></i></a>
    <a href="{{ url('/progress') }}" class="nav-item"><i class="fas fa-list"></i></a>
    <a href="{{ url('/appointments') }}" class="nav-item active"><i class="fas fa-clock"></i></a>
    <a href="{{ url('/workoutlogs') }}" class="nav-item"><i class="far fa-check-circle"></i></a>
    <a href="{{ url('/alerts') }}" class="nav-item"><i class="fas fa-comment"></i></a>
    <a href="{{ url('/clientprofile') }}" class="nav-item"><i class="fas fa-user"></i></a>
</nav>

<!-- Modal for booking confirmation -->
<div id="bookingModal" class="modal-overlay">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h3 class="modal-title">Confirm Booking</h3>
        <div id="booking-details">
            <!-- Booking details will be displayed here -->
        </div>
        <div class="modal-buttons">
            <button class="btn-cancel" onclick="closeModal()">Cancel</button>
            <button class="btn-confirm" onclick="confirmBooking()">Confirm Booking</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Pull the correct URL from your named route:
    const slotsUrl = @json(route('appointments.available-time-slots'));

    // Global variables
    let selectedDate = null;
    let selectedTimeSlot = null;
    let selectedEmployeeId = 1; // Default employee ID

    $(document).ready(function() {
        initializeCalendar();

        // Handle date selection
        $(document).on('click', '.calendar-day:not(.empty)', function() {
            $('.calendar-day').removeClass('selected');
            $(this).addClass('selected');

            selectedDate = $(this).data('date');
            loadTimeSlots(selectedDate);
        });

        // Handle time slot selection
        $(document).on('click', '.time-slot', function() {
            $('.time-slot').removeClass('selected');
            $(this).addClass('selected');

            selectedTimeSlot = {
                start:     $(this).data('start'),
                end:       $(this).data('end'),
                formatted: $(this).text()
            };
            showBookingModal();
        });
    });

    function initializeCalendar() {
        const today = new Date();
        let month = today.getMonth();
        let year  = today.getFullYear();

        renderCalendar(month, year);

        $('#prev-month').click(() => {
            ({month, year} = shiftMonth(month, year, -1));
            renderCalendar(month, year);
        });
        $('#next-month').click(() => {
            ({month, year} = shiftMonth(month, year, +1));
            renderCalendar(month, year);
        });
    }

    function renderCalendar(month, year) {
        $('#current-month').text(getMonthName(month) + ' ' + year);

        const firstDay    = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const grid        = $('.calendar-grid').empty();

        ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'].forEach(d => {
            grid.append(`<div class="calendar-header">${d}</div>`);
        });
        for (let i = 0; i < firstDay; i++) {
            grid.append('<div class="calendar-day empty"></div>');
        }
        const todayStr = new Date().toDateString();
        for (let d = 1; d <= daysInMonth; d++) {
            const dateObj = new Date(year, month, d);
            const iso     = dateObj.toISOString().split('T')[0];
            const cls     = dateObj.toDateString() === todayStr ? 'today' : '';
            grid.append(`
                <div class="calendar-day ${cls}" data-date="${iso}">
                    ${d}
                </div>
            `);
        }
    }

    function shiftMonth(month, year, delta) {
        month += delta;
        if (month < 0) { month = 11; year--; }
        if (month > 11) { month = 0; year++; }
        return {month, year};
    }

    function getMonthName(idx) {
        return ['January','February','March','April','May','June',
                'July','August','September','October','November','December'][idx];
    }

    function loadTimeSlots(date) {
    // Debug logging — check in DevTools Console
    console.log(
        '🛠️ Fetching slots from:', 
        slotsUrl, 
        'with employee_id =', 
        selectedEmployeeId, 
        'for date =', 
        date
    );

    $('#time-slots-list').empty();
    $('#loading-message').text('Loading available time slots...');

    $.ajax({
        url:    slotsUrl,              // Use the named route
        method: 'GET',
        data: {
            date:        date,
            employee_id: selectedEmployeeId  // Always an integer
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success(response) {
            $('#loading-message').text('');

            if (response.success && response.slots.length > 0) {
                response.slots.forEach(slot => {
                    $('#time-slots-list').append(`
                        <div class="time-slot" data-start="${slot.start}" data-end="${slot.end}">
                            ${slot.formatted}
                        </div>
                    `);
                });
            } else {
                $('#loading-message').text('No available time slots for this date. Please select another date.');
            }
        },
        error(xhr, status, error) {
            console.error('Error loading time slots:', xhr.responseText || error);
            $('#loading-message').text('Error loading time slots. Please try again.');
        }
    });
}


    function showBookingModal() {
        $('#booking-details').html(`
            <p><strong>Date:</strong> ${formatDate(selectedDate)}</p>
            <p><strong>Time:</strong> ${selectedTimeSlot.formatted}</p>
            <p><strong>Trainer:</strong> Your Ntencity Trainer</p>
        `);
        $('#bookingModal').css('display', 'flex');
    }

    function closeModal() {
        $('#bookingModal').css('display', 'none');
    }

    function formatDate(dateString) {
        return new Date(dateString).toLocaleDateString('en-US', {
            weekday:'long', year:'numeric', month:'long', day:'numeric'
        });
    }

    function confirmBooking() {
        const bookingData = {
            booking_date: selectedDate,
            start_time:   selectedTimeSlot.start,
            end_time:     selectedTimeSlot.end,
            employee_id:  selectedEmployeeId,
            status:       'confirmed'
        };

        $.ajax({
            url:    '/appointments',
            method: 'POST',
            data:   bookingData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success(response) {
                if (response.success) {
                    closeModal();
                    alert('Appointment booked successfully!');
                    loadTimeSlots(selectedDate);
                } else {
                    alert('Failed to book appointment. Please try again.');
                }
            },
            error(xhr, status, error) {
                console.error('Error booking appointment:', xhr.responseText || error);
                alert('Error booking appointment. Please try again.');
            }
        });
    }
</script>
@endsection


<style>
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
        background-color: #fff;
        border-bottom: 1px solid #eee;
    }
    
    .logo {
        width: 135px;
        height: auto;
    }
    
    .user-info {
        display: flex;
        align-items: center;
        font-weight: 500;
    }
    
    .user-info i {
        margin-left: 8px;
        color: #C96E04;
    }
    
    .content-header {
        padding: 15px;
        text-align: center;
    }
    
    .content-header h1 {
        font-size: 1.5rem;
        color: #333;
        margin-bottom: 20px;
    }
    
    .calendar-container {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        padding: 15px;
        margin-bottom: 20px;
    }
    
    .month-selector {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .month-selector button {
        background: none;
        border: none;
        font-size: 1.2rem;
        color: #C96E04;
        cursor: pointer;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .month-selector button:hover {
        background-color: #f5f5f5;
    }
    
    #current-month {
        font-size: 1.1rem;
        font-weight: 500;
    }
    
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
    }
    
    .calendar-header {
        text-align: center;
        font-weight: 500;
        font-size: 0.8rem;
        color: #666;
        padding: 5px 0;
    }
    
    .calendar-day {
        aspect-ratio: 1/1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .calendar-day:hover:not(.empty) {
        background-color: #f0f0f0;
    }
    
    .calendar-day.today {
        border: 2px solid #C96E04;
        font-weight: bold;
    }
    
    .calendar-day.selected {
        background-color: #C96E04;
        color: white;
    }
    
    .calendar-day.empty {
        cursor: default;
    }
    
    .time-slots-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-top: 15px;
    }
    
    .time-slot {
        padding: 10px;
        text-align: center;
        background-color: #f9f9f9;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid #ddd;
    }
    
    .time-slot:hover {
        background-color: #f0f0f0;
        transform: translateY(-2px);
    }
    
    .time-slot.selected {
        background-color: #C96E04;
        color: white;
        border-color: #C96E04;
    }
    
    #loading-message {
        text-align: center;
        color: #666;
        padding: 15px 0;
    }
    
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }
    
    .modal-content {
        background: white;
        border-radius: 12px;
        padding: 20px;
        width: 85%;
        max-width: 350px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    .modal-title {
        color: #C96E04;
        margin-bottom: 15px;
        font-weight: 600;
    }
    
    .close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        cursor: pointer;
        color: #666;
    }
    
    .modal-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }
    
    .btn-cancel, .btn-confirm {
        padding: 10px 15px;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        border: none;
    }
    
    .btn-cancel {
        background-color: #f3f3f3;
        color: #666;
    }
    
    .btn-confirm {
        background-color: #C96E04;
        color: white;
    }
    
    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: white;
        display: flex;
        justify-content: space-around;
        padding: 10px 0;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        z-index: 900;
    }
    
    .nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #666;
        text-decoration: none;
        font-size: 1.2rem;
        padding: 5px 0;
    }
    
    .nav-item.active {
        color: #C96E04;
    }
</style>