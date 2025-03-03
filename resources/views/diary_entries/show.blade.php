@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fw-bold">View Client Progress Notes</h2><br>

    <p>
        <strong>Employee:</strong> 
        @if($diaryEntry->employee)
            {{ $diaryEntry->employee->emp_first_name }} {{ $diaryEntry->employee->emp_surname }}
        @else
            <span class="text-danger">No employee assigned</span>
        @endif
    </p>

<p><strong>Client:</strong> {{ $diaryEntry->client->first_name }} {{ $diaryEntry->client->surname }}</p>

    <form action="{{ route('diary-entries.update', $diaryEntry->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <textarea name="content" class="form-control" rows="5" required>{{ $diaryEntry->content }}</textarea>
        </div>

        <!-- Centered Buttons -->
        <div class="d-flex justify-content-start mt-3">
            <a href="{{ route('diary-entries.index', $diaryEntry->client->id) }}" class="btn btn-primary me-3">
                <i class="fas fa-arrow-left"></i> Back to Entries
            </a>
        </div>
    </form>
</div>

<style>
    /* Heading Styles */
    h1, h2, h3, h4, h5, h6 {
        font-weight: bold !important;
        font-size: 2rem !important; /* Adjust size */
    }

    /* Common Button Styles  */
    .btn-primary {
        background-color: #C96E04 !important; /* Orange */
        color: white !important;
        font-weight: bold;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 15px;
        transition: 0.3s;
        text-decoration: none;
    }

    /* Hover Effect */
    .btn-primary:hover {
        background-color: #A85C03 !important; /* Darker Orange */
    }

    /* Styled Textarea */
    .form-control {
        background-color: #FFF7ED !important; /* Soft Beige */
    }
</style>
@endsection
