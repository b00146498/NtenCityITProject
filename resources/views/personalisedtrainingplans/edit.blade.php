@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-white d-flex justify-content-between">
            <h4 class="fw-bold">Edit Personalised Training Plan</h4>
            <a href="{{ route('personalisedtrainingplans.index') }}" class="text-white text-decoration-none fw-bold">✖ Close</a>
        </div>
        <div class="card-body">
            @include('basic-template::common.errors')

            {!! Form::model($personalisedtrainingplan, ['route' => ['personalisedtrainingplans.update', $personalisedtrainingplan->id], 'method' => 'patch']) !!}

                <!-- Client Selection via Live Search -->
                <div class="col-md-12 mb-3">
                    {!! Form::label('client_id', 'Search Client:', ['class' => 'form-label fw-bold text-dark']) !!}
                    <div class="position-relative">
                        <input type="text" id="client-search" class="form-control search-input" 
                            placeholder="Type client name..." 
                            value="{{ $personalisedtrainingplan->client ? $personalisedtrainingplan->client->first_name . ' ' . $personalisedtrainingplan->client->surname : '' }}"
                            autocomplete="off">
                        <input type="hidden" name="client_id" id="selected-client-id" value="{{ $personalisedtrainingplan->client_id }}">
                        <div id="client-list" class="list-group shadow-sm position-absolute w-100 bg-white rounded border border-secondary" style="max-height: 200px; overflow-y: auto; display: none;"></div>
                    </div>
                </div>

                <!-- Start Date -->
                <div class="col-md-6 mb-3">
                    {!! Form::label('start_date', 'Start Date:', ['class' => 'form-label fw-bold']) !!}
                    {!! Form::date('start_date', $personalisedtrainingplan->start_date, ['class' => 'form-control bg-light', 'required']) !!}
                </div>

                <!-- End Date -->
                <div class="col-md-6 mb-3">
                    {!! Form::label('end_date', 'End Date:', ['class' => 'form-label fw-bold']) !!}
                    {!! Form::date('end_date', $personalisedtrainingplan->end_date, ['class' => 'form-control bg-light', 'required']) !!}
                </div>

                <!-- Centered Buttons -->
                <div class="col-12 d-flex justify-content-center mt-4">
                    <a href="{{ route('personalisedtrainingplans.index') }}" class="btn btn-outline-dark px-4 py-2 me-3">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4 py-2">Save Changes</button>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
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

