@extends('layouts.mobile')

@section('content')

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <!-- Logo on the Left -->
        <img src="{{ asset('ntencitylogo.png') }}" alt="Ntencity Logo" class="logo">

        <!-- User Name on the Right -->
        @auth
            <div class="user-info">
                {{ Auth::user()->name }}<i class="fas fa-user"></i>
            </div>
        @endauth
    </div>

    <!-- Search Bar -->
    <div class="col-md-12 mb-3">
        {!! Form::label('employee_id', 'Search Employee:', ['class' => 'form-label fw-bold text-dark']) !!}
        <div class="position-relative">
            <input type="text" id="employee-search" class="form-control search-input" placeholder="Type employee name..." autocomplete="off">
            <input type="hidden" name="employee_id" id="selected-employee-id">
            <div id="employee-list" class="list-group shadow-sm position-absolute w-100 bg-white rounded border border-secondary" style="max-height: 200px; overflow-y: auto; display: none;"></div>
        </div>
    </div>

    <h3 class="section-title">List of Professionals</h3>

    @forelse($employees as $employee)
        <div class="professional-card" id="employee-{{ $employee->id }}">
            <div class="info">
                <h4>{{ $employee->emp_first_name }} {{ $employee->emp_surname }}</h4>
                <p>{{ $employee->role }}</p>
                <p>Contact: {{ $employee->contact_number }}</p>
            </div>
            <a href="{{ url('/appointments') }}" class="book-btn">Book</a>
        </div>
    @empty
        <p>No professionals available in your selected practice.</p>
    @endforelse

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="#" class="nav-item"><i class="fas fa-home"></i> Home</a>
        <a href="#" class="nav-item"><i class="fas fa-calendar"></i> Appointments</a>
        <a href="#" class="nav-item"><i class="fas fa-user"></i> Profile</a>
        <a href="#" class="nav-item"><i class="fas fa-cog"></i> Settings</a>
    </nav>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let searchInput = document.getElementById("employee-search");
    let employeeList = document.getElementById("employee-list");
    let professionalCards = document.querySelectorAll(".professional-card");

    document.addEventListener("click", function(event) {
        if (!searchInput.contains(event.target) && !employeeList.contains(event.target)) {
            employeeList.style.display = "none";
        }
    });

    searchInput.addEventListener("keyup", function () {
        let query = this.value.trim().toLowerCase();

        if (query.length > 1) {
            employeeList.style.display = "block";
            employeeList.innerHTML = `<div class="list-group-item text-muted">Searching...</div>`; 

            console.log(`Fetching: /search-employees?query=${query}`); // Debugging request

            fetch(`/search-employees?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    console.log("Response received:", data); // Debugging response
                    employeeList.innerHTML = "";

                    if (data.length > 0) {
                        data.forEach(employee => {
                            let item = document.createElement("a");
                            item.href = "#";
                            item.classList.add("list-group-item", "list-group-item-action", "px-3");
                            item.innerHTML = `<strong>${employee.emp_first_name} ${employee.emp_surname}</strong> (${employee.role})`;

                            item.onclick = function (e) {
                                e.preventDefault();
                                searchInput.value = `${employee.emp_first_name} ${employee.emp_surname}`;
                                document.getElementById("selected-employee-id").value = employee.id;
                                employeeList.style.display = "none";

                                // Hide all cards
                                professionalCards.forEach(card => card.style.display = "none");

                                // Show only matching card
                                let selectedCard = document.getElementById(`employee-${employee.id}`);
                                if (selectedCard) {
                                    selectedCard.style.display = "flex";
                                }
                            };

                            employeeList.appendChild(item);
                        });
                    } else {
                        employeeList.innerHTML = `<div class="list-group-item text-muted">No results found</div>`;
                    }
                })
                .catch(error => {
                    console.error("Fetch error:", error);
                    employeeList.innerHTML = `<div class="list-group-item text-danger">Error fetching results</div>`;
                });
        } else {
            employeeList.style.display = "none";
            professionalCards.forEach(card => card.style.display = "flex");
        }
    });
});
</script>

<style>
    /* Dashboard Header */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .logo {
        width: 135px;
        height: auto;
    }

    .user-info {
        display: flex;
        align-items: center;
    }

    .user-info i {
        font-size: 18px;
        margin-left: 10px;
    }

    /* Search Bar */
    .search-container {
        position: relative;
        margin-bottom: 15px;
    }

    .search-bar {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .search-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #777;
    }

    /* Professional Cards */
    .professional-card {
        background: rgba(212, 175, 55, 0.15);
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .book-btn {
        background: #C96E04;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
    }

    /* Bottom Navigation */
    .bottom-nav {
        position: fixed;
        bottom: 0;
        width: 100%;
        background: white;
        display: flex;
        justify-content: space-around;
        padding: 10px;
        box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
    }

    .nav-item {
        text-align: center;
        font-size: 14px;
        color: black;
        text-decoration: none;
    }

    .nav-item i {
        font-size: 20px;
        display: block;
    }
    body, html {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #F3F3F3;
    }
</style>

@endsection
