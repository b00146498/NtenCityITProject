@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Client Progress Notes <i class="fa fa-paperclip"></i></h2>
    <br>
    <!-- Search Bar (Place it here, above the table) -->
    <form method="GET" action="{{ route('diary-entries.index') }}" class="d-flex" style="max-width: 300px;">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by client name..." value="{{ request('search') }}">
            <button type="submit" class="btn search-btn">
                <i class="fa fa-search"></i> <!-- Search Icon -->
            </button>
        </div>
    </form>
    <br>


    <table class="table">
        <thead>
            <tr>
                <th>Client</th>
                <th>Entry Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="diaryTable">
            @foreach ($diaryEntries as $entry)
                <tr>
                    <td class="client-name">{{ $entry->client->first_name }} {{ $entry->client->surname }}</td>
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

    /* Optional: Style the search bar */
    #searchInput {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    /* Custom Button Styling */
    .search-btn {
        background-color: #C96E04 !important; /* Orange Button */
        border-color: #C96E04 !important; /* Matching Border */
        color: white !important; /* White Icon/Text */
    }

    /* Hover Effect */
    .search-btn:hover {
        background-color: #A85C03 !important; /* Slightly Darker Orange */
        border-color: #A85C03 !important;
    }

    /* Search Input Border (Optional) */
    .form-control {
        border: 1px solid #C96E04 !important;
    }
</style>

<!-- JavaScript for live search -->
<script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#diaryTable tr");

        rows.forEach(row => {
            let clientName = row.querySelector(".client-name").textContent.toLowerCase();
            if (clientName.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>

@endsection
