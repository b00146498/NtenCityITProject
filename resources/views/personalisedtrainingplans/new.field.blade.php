<div class="row">
    <!-- Client Selection -->
    <div class="col-md-6 mb-3">
        {!! Form::label('client_id', 'Client:', ['class' => 'form-label fw-bold']) !!}
        <select name="client_id" class="form-select">
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ $client->id == $personalisedtrainingplan->client_id ? 'selected' : '' }}>
                    {{ $client->first_name }} {{ $client->surname }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Start Date -->
    <div class="col-md-6 mb-3">
        {!! Form::label('start_date', 'Start Date:', ['class' => 'form-label fw-bold']) !!}
        {!! Form::date('start_date', $personalisedtrainingplan->start_date ?? null, ['class' => 'form-control', 'required']) !!}
    </div>

    <!-- End Date -->
    <div class="col-md-6 mb-3">
        {!! Form::label('end_date', 'End Date:', ['class' => 'form-label fw-bold']) !!}
        {!! Form::date('end_date', $personalisedtrainingplan->end_date ?? null, ['class' => 'form-control', 'required']) !!}
    </div>


    <!-- Centered Buttons -->
    <div class="d-flex justify-content-center mt-3">
        <a href="{{ route('personalisedtrainingplans.index') }}" class="btn btn-primary me-3">
            <i class="fas fa-arrow-left"></i> Back to Plans
        </a>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>
</div>

<style>
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

    .btn-primary:hover {
        background-color: #A85C03 !important; /* Darker Orange */
    }

    .form-control {
        background-color: #FFF7ED !important;
    }
</style>
