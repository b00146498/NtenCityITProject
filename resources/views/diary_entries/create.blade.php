@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Diary Entry for {{ $client->emp_first_name }} {{ $client->emp_surname }}</h2>

    <form action="{{ route('diary-entries.store') }}" method="POST">
        @csrf
        <input type="hidden" name="client_id" value="{{ $client->id }}">
        <input type="hidden" name="employee_id" value="{{ Auth::user()->id }}">

        <div class="form-group">
            <label for="content">Diary Entry</label>
            <textarea name="content" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-success mt-3">Save Entry</button>
    </form>
</div>
@endsection
