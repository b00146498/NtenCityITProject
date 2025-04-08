@extends('layouts.app')

@section('content')
<div class="container">

<div class="d-flex align-items-center mb-4">
    <div class="icon-circle bg-info-subtle text-info me-3">
        <img src="{{ asset('progress.png') }}" alt="Exercise Videos" class="progress-icon">
    </div>
    <h2> Client Progress Notes</h2>
</div>

    <!-- Search Bar & Add New Note Button in One Line -->
    <div class="d-flex align-items-center gap-2 mb-3" style="max-width: 600px;">
        <div class="input-group" style="flex-grow: 1;">
            <input type="text" id="searchInput" class="form-control search-input" placeholder="Search by client name..." autocomplete="off">
            <button class="btn search-btn">
                <i class="fa fa-search"></i> <!-- Search Icon -->
            </button>
        </div>
        <a href="{{ route('diary-entries.create') }}" class="btn btn-add-entry">
            <i class="fa fa-plus"></i> Add New Note
        </a>
    </div>


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


/* Custom Search Button */
.search-btn {
    background-color: #C96E04 !important; /* Orange Button */
    border-color: #C96E04 !important; /* Matching Border */
    color: white !important; /* White Icon/Text */
    font-weight: bold;
    padding: 10px 15px;
    border-radius: 5px;
}

/* Hover Effect */
.search-btn:hover {
    background-color: #A85C03 !important; /* Slightly Darker Orange */
    border-color: #A85C03 !important;
}

/* Ensure Button is on One Line */
.btn-add-entry {
    white-space: nowrap; /* Prevents text from wrapping */
    background-color: #C96E04 !important;
    border-color: #C96E04 !important;
    color: white !important;
    font-weight: bold;
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
}

/* Adjust Search Bar Width to Prevent Overflow */
.search-input {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #C96E04 !important;
    border-radius: 5px;
}

.btn-add-entry:hover {
    background-color: #A85C03 !important;
    border-color: #A85C03 !important;
}
.icon-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #fff8e1;
    border: 2px solid #e0c36c;
    color: #a68c30;
}

.progress-icon {
    width: 42px;
    height: 42px;
    object-fit: contain;
}
</style>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#diaryTable tr");

        rows.forEach(row => {
            let clientName = row.querySelector(".client-name")?.textContent.toLowerCase();
            if (clientName && clientName.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>


@endsection
