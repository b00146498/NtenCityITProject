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

        <!-- Client Selection via Live Search -->
        <div class="form-group position-relative" style="max-width: 400px;">
            <label for="client-search" class="fw-bold">Search Client:</label>
            <div class="input-group">
                <input type="text" id="client-search" class="form-control search-input" placeholder="Type client name..." autocomplete="off">
                <button class="btn search-btn"><i class="fa fa-search"></i></button>
            </div>
            <input type="hidden" name="client_id" id="selected-client-id">
            <div id="client-list" class="list-group shadow-sm position-absolute w-100 bg-white"></div>
        </div>

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
    /* Match Search Box Styling */
    .search-input {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #C96E04 !important;
        border-radius: 5px;
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

    /* Ensure Dropdown Appears Above Other Elements */
    #client-list {
        position: absolute;
        z-index: 1050;
        width: 100%;
        background-color: white;
        border: 1px solid #ccc;
        max-height: 200px;
        overflow-y: auto;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }


</style>

<!-- Live Search AJAX -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let searchInput = document.getElementById("client-search");
        let clientList = document.getElementById("client-list");

        searchInput.addEventListener("keyup", function () {
            let query = this.value;

            if (query.length > 1) {
                fetch(`/search-clients?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        clientList.innerHTML = "";
                        if (data.length > 0) {
                            data.forEach(client => {
                                let item = document.createElement("a");
                                item.href = "#";
                                item.classList.add("list-group-item", "list-group-item-action");
                                item.textContent = `${client.first_name} ${client.surname}`;
                                item.onclick = function () {
                                    searchInput.value = `${client.first_name} ${client.surname}`;
                                    document.getElementById("selected-client-id").value = client.id;
                                    clientList.innerHTML = "";
                                };
                                clientList.appendChild(item);
                            });
                        } else {
                            clientList.innerHTML = `<div class="list-group-item">No results found</div>`;
                        }
                    });
            } else {
                clientList.innerHTML = "";
            }
        });
    });
</script>
@endsection
