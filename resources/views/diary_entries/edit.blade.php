@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fw-bold">Edit Client Progress Notes</h2><br>

    <p><strong>Client:</strong> {{ $diaryEntry->client->first_name }} {{ $diaryEntry->client->surname }}</p><br>

    <form action="{{ route('diary-entries.update', $diaryEntry->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <textarea name="content" class="form-control" rows="5" required>{{ $diaryEntry->content }}</textarea>
        </div>

        <!-- Centered Buttons -->
        <div class="d-flex justify-content-start mt-3">
            <a href="{{ route('diary-entries.index') }}" class="btn btn-primary me-3">
                <i class="fas fa-arrow-left"></i> Back to Entries
            </a>
            <button type="submit" class="btn btn-primary">Update Entry</button>
        </div>
    </form>
</div>

<style>
    /* Heading Styles */
    h1, h2, h3, h4, h5, h6 {
        font-weight: bold !important;
        font-size: 2rem !important; /* Adjust size */
    }

    /* Common Button Styles (Back & Update) */
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
    .form-control {
        background-color: #FFF7ED !important;
    }
</style>
@endsection
