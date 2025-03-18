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
    <div class="form-group position-relative" style="max-width: 400px;">
        <div class="input-group">
            <input type="text" id="employee-search" class="form-control search-input" placeholder="Type employee name..." autocomplete="off">
            <button class="btn search-btn"><i class="fa fa-search"></i></button>
        </div>
        <input type="hidden" name="employee_id" id="selected-employee-id">
        <div id="employee-list" class="list-group shadow-sm position-absolute w-100 bg-white rounded border border-secondary" style="max-height: 200px; overflow-y: auto; display: none;"></div>
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
        <a href="{{ url('/client/clientdashboard') }}" class="nav-item"><i class="fas fa-home"></i></a>
        <a href="{{ url('/progress') }}" class="nav-item"><i class="fas fa-list"></i></i></a>
        <a href="{{ url('/appointments') }}" class="nav-item"><i class="fas fa-clock"></i></i></a>
        <a href="#" class="nav-item"><i class="fas fa-comment"></i></a>
        <a href="#" class="nav-item"><i class="fas fa-user"></i></a>
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

            fetch(`/search-employees?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    employeeList.innerHTML = "";

                    if (data.length > 0) {
                        data.forEach(employee => {
                            let item = document.createElement("a");
                            item.href = "#";
                            item.classList.add("list-group-item", "list-group-item-action", "px-3", "d-flex", "justify-content-between", "align-items-center");
                            item.innerHTML = `
                                <div>
                                    <strong>${employee.emp_first_name} ${employee.emp_surname}</strong>
                                    <small class="text-muted d-block">${employee.role}</small>
                                </div>
                                <i class="fas fa-user-md text-primary"></i>
                            `;

                            item.onclick = function (e) {
                                e.preventDefault();
                                searchInput.value = `${employee.emp_first_name} ${employee.emp_surname}`;
                                document.getElementById("selected-employee-id").value = employee.id;
                                employeeList.style.display = "none";

                                professionalCards.forEach(card => card.style.display = "none");
                                let selectedCard = document.getElementById(`employee-${employee.id}`);
                                if (selectedCard) {
                                    selectedCard.style.display = "flex";
                                }
                            };

                            employeeList.appendChild(item);
                        });
                    } else {
                        employeeList.innerHTML = `<div class="list-group-item text-muted">No employees found</div>`;
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
    /* Ensure full-page layout */

html, body {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #F3F3F3;
    overflow-x: hidden; /* Prevent horizontal scrolling */
}

/* Main container */
.mobile-container {
    max-width: 350px;
    width: 100%;
    margin: auto;
    padding: 20px;
    background: white;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 15px; /* Rounded corners on all sides */
    display: flex;
    flex-direction: column;
    min-height: 100vh; /* Makes sure the page is at least full height */
    position: relative;
    overflow: hidden; /* Prevents scrollbar inside container */
}

/* Make content scrollable */
.content {
    flex: 1;
    overflow-y: auto;
    padding-bottom: 80px; /* Prevents content from overlapping with bottom nav */
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* Internet Explorer/Edge */
}

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

/* Book Button */
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
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    max-width: 350px; /* Matches the mobile display width */
    background: white;
    display: flex;
    justify-content: space-around;
    padding: 12px 0;
    box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
    border-top: 1px solid #ccc;
    z-index: 1000;
    border-radius: 0 0 15px 15px; /* Rounded bottom corners */
}

/* Navigation Items */
.nav-item {
    text-align: center;
    font-size: 14px;
    color: black;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    font-weight: bold;
}

/* Icons in Navbar */
.nav-item i {
    font-size: 20px;
    margin-bottom: 3px;
}

/* Search Bar */
.search-container {
    position: relative;
    margin-bottom: 15px;
}

/* Ensure the input and button stay on the same line */
.input-group {
    display: flex;
    align-items: center;
    width: 100%;
}

/* Style the search input */
.search-input {
    background-color: #F0ECEC !important; /* Light gray background */
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 5px 0 0 5px; /* Rounded on left side */
    flex: 1; /* Makes sure it fills the available space */
}

/* Style the search button */
.search-btn {
    background-color: #D4AF37; /* Gold color */
    border: 1px solid #D4AF37;
    color: white;
    border-radius: 0 5px 5px 0; /* Rounded only on the right side */
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    cursor: pointer;
}

/* Search Button Hover Effect */
.search-btn:hover {
    background-color: #B5952C; /* Slightly darker gold */
}

/* Dropdown Search List */
#employee-list {
    background: white;
    border: 1px solid #ccc;
    border-radius: 5px;
    max-height: 200px;
    overflow-y: auto;
}

/* Mobile Responsive Fix */
@media (max-width: 480px) {
    .bottom-nav {
        max-width: 100%;
    }
}


</style>

@endsection
