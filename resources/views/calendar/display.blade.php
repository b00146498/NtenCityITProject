@extends('layouts.app')

@section('content')
@include('calendar.modalbooking')

<!-- ✅ New Appointment Button -->
<button id="newAppointmentBtn" class="btn new-appointment-btn" data-toggle="modal" data-target="#fullCalModal">
    + New Appointment
</button>

<div id="calendar"></div>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    #calendar {
        max-width: 100%;
        margin: 0 auto;
    }

    /* Time slots background colors */
    .fc-timegrid-slot-lane {
        background-color: #e9ecef;
    }

    .fc-timegrid-slot[data-time^='09:00'], .fc-timegrid-slot[data-time^='10:00'] {
        background-color: #d1ecf1;
    }

    .fc-timegrid-slot[data-time^='12:00'], .fc-timegrid-slot[data-time^='13:00'], .fc-timegrid-slot[data-time^='14:00'] {
        background-color: #c8e6c9;
    }

    .fc-timegrid-slot[data-time^='15:00'], .fc-timegrid-slot[data-time^='16:00'], .fc-timegrid-slot[data-time^='17:00'] {
        background-color: #fde0dc;
    }

    .fc-timegrid-slot[data-time^='18:00'], .fc-timegrid-slot[data-time^='19:00'], .fc-timegrid-slot[data-time^='20:00'] {
        background-color: #fff9c4;
    }

    /* Header Toolbar */
    .fc-header-toolbar {
        background: #fff;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    /* FullCalendar Button Styles */
    .fc-button {
        background-color: #c9a86a !important;
        border: none !important;
        color: white !important;
        padding: 8px 16px;
        border-radius: 4px;
        font-weight: bold;
    }

    .fc-button:hover {
        background-color: #a8894f !important;
    }

    /* Active View Button */
    .fc-button-active {
        background-color: #b78b50 !important;
        border-color: #a67c47 !important;
    }

    /* ✅ New Appointment Button Styling */
    .new-appointment-btn {
        background-color: #c9a86a !important;
        border: none !important;
        color: white !important;
        padding: 10px 16px;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        margin-bottom: 10px;
    }

    .new-appointment-btn:hover {
        background-color: #a8894f !important;
    }
</style>

<!-- ✅ Load Required Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [window.dayGridPlugin, window.timeGridPlugin, window.listPlugin, window.interactionPlugin],
        initialView: 'timeGridWeek',
        initialDate: new Date().toISOString().split("T")[0], 
        slotMinTime: '08:00:00', 
        slotMaxTime: '22:00:00',
        height: "auto", 
        eventMinHeight: 30,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        events: "{{ route('appointment.json') }}",
        eventSourceFailure: function(error) {
            console.error("❌ FullCalendar Event Fetch Failed:", error);
        },

        // ✅ New Appointment Click Event
        dateClick: function(info) {
            console.log("📌 Date Clicked:", info.date.toISOString()); 
            $('#starttime').val(info.date.toISOString().substring(11,16));
            $('#bookingDate').val(info.date.toISOString().substring(0,10));
            $('#fullCalModal').modal('show'); 
        }
    });

    calendar.render();

    // ✅ AJAX Submit to Prevent Redirect & Refresh Calendar
    $('#createAppointmentForm').submit(function(event) {
        event.preventDefault(); // Stop Default Form Submission

        $.ajax({
            url: "{{ route('appointments.store') }}",
            method: "POST",
            data: $(this).serialize(), 
            success: function(response) {
                if (response.success) {
                    $('#fullCalModal').modal('hide'); // ✅ Close Modal
                    alert("✅ Appointment saved successfully!"); // ✅ Show Success Message

                    // ✅ Refresh Calendar Without Page Reload
                    calendar.refetchEvents(); // ✅ Instantly Reload Events
                } else {
                    alert("❌ Error: " + response.message); 
                }
            },
            error: function(error) {
                console.error("❌ AJAX Error:", error);
                alert("❌ Failed to save appointment.");
            }
        });
    });

});
</script>

@endsection
