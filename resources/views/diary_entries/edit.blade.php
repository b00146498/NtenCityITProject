@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Diary Entry</h2>

    <form action="{{ route('diary-entries.update', $diaryEntry->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="content">Diary Entry</label>
            <textarea name="content" class="form-control" rows="5" required>{{ $diaryEntry->content }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Entry</button>
    </form>
</div>
@endsection
