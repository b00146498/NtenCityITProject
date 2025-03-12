<div class="container d-flex justify-content-center">
    <div class="form-box p-4 shadow-lg">
        <h2 class="text-center mb-4 text-dark">Create Training Plan</h2>

        <!-- Client Selection via Live Search -->
        <div class="col-md-12 mb-3">
            {!! Form::label('client_id', 'Search Client:', ['class' => 'form-label fw-bold text-dark']) !!}
            <div class="position-relative">
                <input type="text" id="client-search" class="form-control search-input" placeholder="Type client name..." autocomplete="off">
                <input type="hidden" name="client_id" id="selected-client-id">
                <div id="client-list" class="list-group shadow-sm position-absolute w-100 bg-white rounded border border-secondary" style="max-height: 200px; overflow-y: auto; display: none;"></div>
            </div>
        </div>

        <!-- Start Date Field -->
        <div class="form-group col-sm-12 mb-3">
            {!! Form::label('start_date', 'Start Date:', ['class' => 'text-dark fw-bold']) !!}
            {!! Form::date('start_date', null, ['class' => 'form-control datepicker']) !!}
        </div>

        <!-- End Date Field -->
        <div class="form-group col-sm-12 mb-3">
            {!! Form::label('end_date', 'End Date:', ['class' => 'text-dark fw-bold']) !!}
            {!! Form::date('end_date', null, ['class' => 'form-control datepicker']) !!}
        </div>


        <!-- Submit Field -->
        <div class="form-group col-sm-12 text-center">
            {!! Form::submit('Save', ['class' => 'btn btn-primary px-4']) !!}
            <a href="{!! route('personalisedtrainingplans.index') !!}" class="btn btn-outline-secondary px-4">Cancel</a>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let searchInput = document.getElementById("client-search");
        let clientList = document.getElementById("client-list");

        document.addEventListener("click", function(event) {
            if (!searchInput.contains(event.target) && !clientList.contains(event.target)) {
                clientList.style.display = "none";
            }
        });

        searchInput.addEventListener("keyup", function () {
            let query = this.value.trim();

            if (query.length > 1) {
                clientList.style.display = "block";
                clientList.innerHTML = `<div class="list-group-item text-muted">Searching...</div>`; // Loading indicator
                
                fetch(`/search-clients?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        clientList.innerHTML = "";
                        if (data.length > 0) {
                            data.forEach(client => {
                                let item = document.createElement("a");
                                item.href = "#";
                                item.classList.add("list-group-item", "list-group-item-action", "px-3");
                                item.innerHTML = `<strong>${client.first_name} ${client.surname}</strong>`;
                                item.onclick = function (e) {
                                    e.preventDefault();
                                    searchInput.value = `${client.first_name} ${client.surname}`;
                                    document.getElementById("selected-client-id").value = client.id;
                                    clientList.style.display = "none";
                                };
                                clientList.appendChild(item);
                            });
                        } else {
                            clientList.innerHTML = `<div class="list-group-item text-muted">No results found</div>`;
                        }
                    });
            } else {
                clientList.style.display = "none";
            }
        });
    });

    // Improve date input UX with a modern date picker (flatpickr)
    document.addEventListener("DOMContentLoaded", function () {
        if (typeof flatpickr !== "undefined") {
            flatpickr(".datepicker", {
                dateFormat: "Y-m-d",
                allowInput: true
            });
        }
    });
</script>

<!-- Include Flatpickr for a modern date picker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
    /* Container Alignment */
    .container {
        margin-top: 50px; /* Puts the form higher on the page */
    }

    /* Form Box Styling */
    .form-box {
        background-color: #EEE0B1; /* Light Beige/Orange */
        border-radius: 12px;
        padding: 30px;
        width: 600px; /* Increased width */
        text-align: center;
        border: 2px solid #E6A961;
    }

    /* Input Fields */
    .form-control {
        background-color: #FFF7ED !important;
        border: 2px solid #E6A961;
        color: #333;
    }
    .form-control:focus {
        border-color: #FFD27F;
        box-shadow: 0 0 8px rgba(255, 165, 0, 0.5);
    }

    /* Buttons */
    /* Common Button Styles (Back & Update) */
    .btn-primary {
        background-color: #C96E04 !important; /* Orange */
        color: white !important;
        font-weight: bold;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 15px;
        transition: 0.3s;
        text-decoration: none;
    }

    /* Hover Effect */
    .btn-primary:hover {
        background-color: #A85C03 !important; /* Darker Orange */
    }

    /* Cancel Button */
    .btn-outline-secondary {
        border: 2px solid #FF8C00;
        color: #FF8C00 !important;
        font-weight: bold;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 16px;
        transition: 0.3s;
    }
    .btn-outline-secondary:hover {
        background-color: #FF8C00 !important;
        color: white !important;
    }

    /* Labels */
    .text-dark {
        color: #333 !important;
    }

    /* Client Search Dropdown */
    .list-group-item:hover {
        background-color: #FFD27F !important;
        color: #333 !important;
    }
</style>
