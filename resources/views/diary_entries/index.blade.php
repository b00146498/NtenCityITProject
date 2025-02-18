@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Diary Entries for {{ $client->emp_first_name }} {{ $client->emp_surname }}</h2>

    <a href="{{ route('diary-entries.create', $client->id) }}" class="btn btn-primary">Add New Entry</a>

    <ul class="list-group mt-3">
        @foreach ($diaryEntries as $entry)
            <li class="list-group-item">
                <strong>{{ $entry->entry_date }}</strong> - {{ Str::limit($entry->content, 100) }}
                <a href="{{ route('diary-entries.show', $entry->id) }}" class="btn btn-info btn-sm">View</a>
                @if ($entry->employee_id === Auth::user()->id)
                    <a href="{{ route('diary-entries.edit', $entry->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('diary-entries.destroy', $entry->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                @endif
            </li>
        @endforeach
    </ul>
</div>
@endsection
