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

    /* Button styles */
    .fc-button {
        background-color: #007bff;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .fc-button:hover {
        background-color: #0056b3;
    }
</style>

<script src="{{ asset('js/calendar.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
            initialView: 'timeGridWeek',
            slotMinTime: '09:00:00',
            slotMaxTime: '21:00:00',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            }
        });

        calendar.render();
    });
</script>
@endsection
