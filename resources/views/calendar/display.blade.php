@extends('layouts.app')

@section('content')

<link href="{{ asset('core/main.css')}}" rel='stylesheet' />
<link href="{{ asset('daygrid/main.css')}}" rel='stylesheet' />
<link href="{{ asset('timegrid/main.css')}}" rel='stylesheet' />
<link href="{{ asset('list/main.css')}}" rel='stylesheet' />

<script src="{{ asset('core/main.js')}}"></script>
<script src="{{ asset('interaction/main.js')}}"></script>
<script src="{{ asset('daygrid/main.js')}}"></script>
<script src="{{ asset('timegrid/main.js')}}"></script>
<script src="{{ asset('list/main.js')}}"></script>

<div id="calendar"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['dayGrid', 'timeGrid', 'list', 'interaction'],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            slotDuration: '00:10:00',
            defaultDate: '{{ now()->toDateString() }}', // Uses Laravel to get today's date
            editable: true,
            eventLimit: true,
            events: [
                { title: 'Sample Event', start: '{{ now()->toDateString() }}' }
            ]
        });
        calendar.render();
    });
</script>

@endsection
 