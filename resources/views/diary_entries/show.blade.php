@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Diary Entry - {{ $diaryEntry->entry_date }}</h2>

    <p><strong>Employee:</strong> {{ $diaryEntry->employee->emp_first_name }} {{ $diaryEntry->employee->emp_surname }}</p>
    <p><strong>Client:</strong> {{ $diaryEntry->client->emp_first_name }} {{ $diaryEntry->client->emp_surname }}</p>
    
    <div class="card p-3">
        <p>{{ $diaryEntry->content }}</p>
    </div>

    <a href="{{ route('diary-entries.index', $diaryEntry->client->id) }}" class="btn btn-secondary mt-3">Back to Entries</a>

    @if ($diaryEntry->employee_id === Auth::user()->id)
        <a href="{{ route('diary-entries.edit', $diaryEntry->id) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('diary-entries.destroy', $diaryEntry->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    @endif
</div>
@endsection
