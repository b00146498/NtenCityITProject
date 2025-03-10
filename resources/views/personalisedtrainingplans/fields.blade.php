<!-- Client Selection via Live Search -->
<div class="col-md-6 mb-3">
    {!! Form::label('client_id', 'Search Client:', ['class' => 'form-label fw-bold']) !!}
    <div class="position-relative">
        <input type="text" id="client-search" class="form-control search-input" placeholder="Type client name..." autocomplete="off">
        <input type="hidden" name="client_id" id="selected-client-id">
        <div id="client-list" class="list-group shadow-sm position-absolute w-100 bg-white"></div>
    </div>
</div>

<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', 'Start Date:') !!}
    {!! Form::date('start_date', null, ['class' => 'form-control']) !!}
</div>

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'End Date:') !!}
    {!! Form::date('end_date', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('personalisedtrainingplans.index') !!}" class="btn btn-default">Cancel</a>
</div>


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
