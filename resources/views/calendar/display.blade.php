@extends('layouts.app')

@section('content')
    <div id="calendar"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [ dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin ],
                initialView: 'timeGridWeek',  // Change this line to set the week view as default
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,dayGridMonth,timeGridDay,listWeek'
                },
                events: [
                    { title: 'Event 1', start: '2025-02-18' },
                    { title: 'Event 2', start: '2025-02-20', end: '2025-02-22' }
                ]
            });

            calendar.render();
        });
    </script>
@endsection
