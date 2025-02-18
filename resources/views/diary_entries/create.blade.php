@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Diary Entry</h2>

    <!-- Display Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Diary Entry Form -->
    <form action="{{ route('diary-entries.store') }}" method="POST">
        @csrf

        <!-- Select Client -->
        <div class="form-group">
            <label for="client_id">Select Client</label>
            <select name="client_id" class="form-control" required>
                <option value="">-- Choose a Client --</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Diary Entry Content -->
        <div class="form-group">
            <label for="content">Diary Entry</label>
            <textarea name="content" class="form-control" rows="5" required></textarea>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success mt-3">Save Entry</button>
    </form>
</div>
@endsection
