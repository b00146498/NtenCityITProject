@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Title Section -->
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="fw-bold">Client Progress Notes</h1>

        <!-- Date Box -->
        <div class="date-box p-3 d-flex align-items-center shadow-sm">
            <i class="fas fa-calendar-check me-2"></i>
            <span class="fw-bold">{{ now()->format('d/m/Y') }}</span>
        </div>
    </div>

    <!-- Diary Entry Form -->
    <form action="{{ route('diary-entries.store') }}" method="POST">
        @csrf

        <!-- Client Selection -->
        @if(isset($client))
            <!-- Pre-selected Client -->
            <h4 class="mt-2 text-muted">{{ $client->first_name }}</h4>
            <input type="hidden" name="client_id" value="{{ $client->id }}">
        @else
            <!-- Dropdown for Client Selection -->
            <div class="form-group" style="max-width: 300px;">
                <select name="client_id" class="form-control" required>
                    <option value="">Choose a Client...</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->first_name }} {{ $client->surname }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <!-- Yellow Lined Textbox -->
        <div class="diary-box mt-3 p-4">
            <textarea name="content" class="lined-textarea" rows="12" required></textarea>
        </div>

        <!-- Centered Buttons -->
        <div class="text-center mt-4 d-flex justify-content-center">
            <!-- Back to Entries Button -->
            <a href="{{ route('diary-entries.index') }}" class="btn back-btn me-3">
                <i class="fas fa-arrow-left"></i> Back to Entries
            </a>

            <!-- Save Diary Entry Button -->
            <button type="submit" class="btn save-btn">
                Save Diary Entry
            </button>
        </div>
    </form>
</div>

<!-- Custom Styles -->
<style>
    /* Yellow Notebook Styling */
    .diary-box {
        background-color: #fdf5c9; /* Soft yellow */
        border: 2px solid #e5c67c;
        border-radius: 8px;
        position: relative;
    }

    .lined-textarea {
        width: 100%;
        height: 100%;
        background: repeating-linear-gradient(white, white 24px, #c9b178 25px);
        border: none;
        outline: none;
        padding: 15px;
        font-size: 16px;
        font-family: 'Arial', sans-serif;
        resize: none;
        line-height: 25px;
    }

    .lined-textarea::placeholder {
        color: #666;
    }

    /* Date Box */
    .date-box {
        background: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
    }

    /* Back Button */
    .back-btn {
        background-color: #C96E04; /* Orange */
        color: white;
        font-weight: bold;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 18px;
        transition: 0.3s;
        text-decoration: none;
    }

    .back-btn:hover {
        background-color: #A85C03; /* Darker orange */
    }

    /* Save Button */
    .save-btn {
        background-color: #C96E04; /* Orange */
        color: white;
        font-weight: bold;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 18px;
        transition: 0.3s;
        text-decoration: none;
    }

    .save-btn:hover {
        background-color: #A85C03;
    }

    h1, h2, h3, h4, h5, h6 {
        font-weight: bold !important;
        font-size: 2rem !important; /* Adjust size */
    }
</style>
@endsection
