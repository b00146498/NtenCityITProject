@extends('layouts.mobile')

@section('content')
<div class="container mt-4">
    <h2>🚴 Strava Connected</h2>
    <p>Your recent activities:</p>

    @forelse ($activities as $activity)
        <div class="card my-3 p-3 shadow-sm">
            <h5>{{ $activity['name'] }}</h5>
            <p><strong>Distance:</strong> {{ round($activity['distance'] / 1000, 2) }} km</p>
            <p><strong>Duration:</strong> {{ gmdate("H:i:s", $activity['elapsed_time']) }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($activity['start_date'])->format('d M Y') }}</p>
        </div>
    @empty
        <p>No recent activities found.</p>
    @endforelse

    <a href="{{ route('workoutlogs') }}" class="btn btn-warning mt-3">Go to Workout Logs</a>
</div>
@endsection