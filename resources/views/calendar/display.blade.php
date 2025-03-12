@extends('layouts.app')

@section('content')
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
        background-color: #e9ecef; /* light gray for non-specific time slots */
    }

    .fc-timegrid-slot[data-time^='09:00'], .fc-timegrid-slot[data-time^='10:00'] {
        background-color: #d1ecf1; /* light blue for morning slots */
    }

    .fc-timegrid-slot[data-time^='12:00'], .fc-timegrid-slot[data-time^='13:00'], .fc-timegrid-slot[data-time^='14:00'] {
        background-color: #c8e6c9; /* light green for early afternoon slots */
    }

    .fc-timegrid-slot[data-time^='15:00'], .fc-timegrid-slot[data-time^='16:00'], .fc-timegrid-slot[data-time^='17:00'] {
        background-color: #fde0dc; /* light red for late afternoon slots */
    }

    .fc-timegrid-slot[data-time^='18:00'], .fc-timegrid-slot[data-time^='19:00'], .fc-timegrid-slot[data-time^='20:00'] {
        background-color: #fff9c4; /* light yellow for evening slots */
    }

    /* Adjusting the header */
    .fc-header-toolbar {
        background: #fff;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    /* Match FullCalendar Button Styles to Sidebar Theme */
    .fc-button {
        background-color: #c9a86a !important;  /* Light Gold (Matches Sidebar) */
        border: none !important;
        color: white !important;
        padding: 8px 16px;
        border-radius: 4px;
        font-weight: bold;
    }

    .fc-button:hover {
        background-color: #a8894f !important; /* Slightly Darker Gold */
    }

    /* Change Active View Button Background */
    .fc-button-active {
        background-color: #b78b50 !important; /* Slightly Darker Gold for Active Button */
        border-color: #a67c47 !important;
    }
</style>


<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [window.dayGridPlugin, window.timeGridPlugin, window.listPlugin, window.interactionPlugin],
        initialView: 'timeGridWeek', // ✅ Default to Week View
        initialDate: new Date().toISOString().split("T")[0], // ✅ Set today as the default date
        slotMinTime: '08:00:00', 
        slotMaxTime: '22:00:00',
        height: "auto", 
        eventMinHeight: 30, // ✅ Ensures short events are visible
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        events: "{{ route('appointment.json') }}",
        eventsSet: function(events) {
            console.log("✅ FullCalendar Loaded Events:", events);
        },
        eventSourceFailure: function(error) {
            console.error("❌ FullCalendar Event Fetch Failed:", error);
        },
        eventDidMount: function(info) {
            console.log("📅 Rendering Event:", info.event);
        }
    });

    calendar.render();
});

</script>
@endsection