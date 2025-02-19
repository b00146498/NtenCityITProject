@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Diary Entries</h2>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Entry Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($diaryEntries as $entry)
                <tr>
                    <td>{{ $entry->id }}</td>
                    <td>{{ $entry->client->name }}</td>
                    <td>{{ $entry->entry_date }}</td>
                    <td>
                        <a href="{{ route('diary-entries.show', $entry->id) }}" class="btn btn-primary">View</a>
                        <a href="{{ route('diary-entries.edit', $entry->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('diary-entries.destroy', $entry->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<style>
    h1, h2, h3, h4, h5, h6 {
        font-weight: bold !important;
        font-size: 2rem !important; /* Adjust size */
    }
</style>
@endsection
