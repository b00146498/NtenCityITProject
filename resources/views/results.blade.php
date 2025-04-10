@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="h6 fw-bold text-dark mb-3">🔍 Search Results for: <span class="text-primary">"{{ $query }}"</span></h2>

    @if($clients->isEmpty() && $employees->isEmpty() && $exercises->isEmpty())
        <div class="alert alert-warning">No results found for <strong>{{ $query }}</strong>.</div>
    @endif

    @if(!$clients->isEmpty())
        <div class="card mb-4 shadow">
            <div class="card-header bg-primary text-white fw-bold">
                👤 Matching Clients
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach($clients as $client)
                        <li class="list-group-item">
                            <strong>{{ $client->first_name }} {{ $client->surname }}</strong> 
                            <span class="text-muted">| Email: {{ $client->email ?? 'N/A' }}</span>
                            <a href="{{ route('clients.show', $client->id) }}" class="btn btn-sm btn-outline-primary float-end">View</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if(!$employees->isEmpty())
        <div class="card mb-4 shadow">
            <div class="card-header bg-success text-white fw-bold">
                🧑‍💼 Matching Employees
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach($employees as $employee)
                        <li class="list-group-item">
                            <strong>{{ $employee->emp_first_name }} {{ $employee->emp_surname }}</strong> 
                            <span class="text-muted">| Role: {{ $employee->role ?? 'N/A' }}</span>
                            <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-outline-success float-end">View</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if(!$exercises->isEmpty())
        <div class="card mb-4 shadow">
            <div class="card-header bg-info text-white fw-bold">
                🏋️ Matching Exercises
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach($exercises as $exercise)
                        <li class="list-group-item">
                            <strong>{{ $exercise->exercise_name }}</strong> 
                            <span class="text-muted">| Target: {{ $exercise->target ?? 'N/A' }}</span>
                            <a href="{{ route('standardexercises.show', $exercise->id) }}" class="btn btn-sm btn-outline-info float-end">View</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
@endsection
