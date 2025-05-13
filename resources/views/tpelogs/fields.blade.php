<div class="row">
    <!-- Training Plan -->
    <div class="col-md-6 mb-3">
        {!! Form::label('plan_id', 'Training Plan (Client):', ['class' => 'form-label fw-bold']) !!}
        <select name="plan_id" class="form-select bg-light">
            <option value="" disabled selected>Select a Training Plan</option>
            @foreach($trainingPlans as $plan)
                <option value="{{ $plan->id }}">
                    {{ $plan->client->first_name ?? 'N/A' }} {{ $plan->client->surname ?? '' }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Exercise Dropdown -->
    <div class="col-md-6 mb-3">
        {!! Form::label('exercise_id', 'Exercise:', ['class' => 'form-label fw-bold']) !!}
        <select name="exercise_id" class="form-select bg-light">
            <option value="" selected disabled>Select an Exercise</option>
            @foreach($exercises as $exercise)
                <option value="{{ $exercise->id }}">
                    {{ $exercise->exercise_name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Number of Sets -->
    <div class="col-md-6 mb-3">
        {!! Form::label('num_sets', 'Number of Sets:', ['class' => 'form-label fw-bold']) !!}
        <div class="input-group">
            <button type="button" class="btn btn-outline-secondary decrease-btn" data-field="num_sets">-</button>
            <input type="number" name="num_sets" id="num_sets" class="form-control text-center bg-light" value="{{ old('num_sets', 0) }}" min="0">
            <button type="button" class="btn btn-outline-secondary increase-btn" data-field="num_sets">+</button>
        </div>
    </div>

    <!-- Number of Reps -->
    <div class="col-md-6 mb-3">
        {!! Form::label('num_reps', 'Number of Reps:', ['class' => 'form-label fw-bold']) !!}
        <div class="input-group">
            <button type="button" class="btn btn-outline-secondary decrease-btn" data-field="num_reps">-</button>
            <input type="number" name="num_reps" id="num_reps" class="form-control text-center bg-light" value="{{ old('num_reps', 0) }}" min="0">
            <button type="button" class="btn btn-outline-secondary increase-btn" data-field="num_reps">+</button>
        </div>
    </div>

    <!-- Minutes -->
    <div class="col-md-6 mb-3">
        {!! Form::label('minutes', 'Minutes:', ['class' => 'form-label fw-bold']) !!}
        <div class="text-center">
            <input type="range" name="minutes" id="minutes" class="form-range" min="1" max="120" value="{{ old('minutes', 30) }}" oninput="updateMinutes(this.value)">
            <h4 id="minutes-display" class="fw-bold mt-2 text-primary">{{ old('min', 30) }} minutes</h4>
        </div>
    </div>

    <!-- Intensity Level -->
    <div class="col-md-6 mb-3">
        {!! Form::label('intensity', 'Intensity Level:', ['class' => 'form-label fw-bold']) !!}
        <select name="intensity" class="form-select bg-light">
            <option value="" selected disabled>Select Intensity</option>
            <option value="Very Light">Very Light</option>
            <option value="Light">Light</option>
            <option value="Moderate">Moderate</option>
            <option value="Vigorous">Vigorous</option>
            <option value="High-Intensity">High-Intensity</option>
            <option value="Maximum Effort">Maximum Effort</option>
        </select>
    </div>


    <!-- Incline/Decline Selection -->
    <div class="form-group col-sm-6">
        {!! Form::label('incline_type', 'Incline or Decline:', ['class' => 'form-label fw-bold']) !!}
        <div class="d-flex align-items-center">
            <!-- None Option (Default) -->
            <input type="radio" name="incline_type" id="none_option" value="none" class="form-check-input" checked>
            <label for="none_option" class="ms-2">None</label>

            <!-- Incline Option -->
            <input type="radio" name="incline_type" id="incline_option" value="incline" class="form-check-input ms-4">
            <label for="incline_option" class="ms-2">Incline</label>

            <!-- Decline Option -->
            <input type="radio" name="incline_type" id="decline_option" value="decline" class="form-check-input ms-4">
            <label for="decline_option" class="ms-2">Decline</label>
        </div>
    </div>


    <!-- Times Per Week -->
    <div class="col-md-6 mb-3">
        {!! Form::label('times_per_week', 'Times Per Week:', ['class' => 'form-label fw-bold']) !!}
        <div class="btn-group w-100" role="group">
            @for ($i = 1; $i <= 7; $i++)
                <input type="radio" class="btn-check" name="times_per_week" id="week_{{ $i }}" 
                    value="{{ $i }}" 
                    @if(old('times_per_week', $personalisedtrainingplan->times_per_week ?? 1) == $i) checked @endif>
                <label class="btn btn-outline-primary" for="week_{{ $i }}">{{ $i }}</label>
            @endfor
        </div>
    </div>

    <!-- Incline/Decline Percentage Input -->
    <div class="col-md-6 mb-3">
        {!! Form::label('incline_value', 'Incline/Decline Percentage:', ['class' => 'form-label fw-bold']) !!}
        <div class="input-group">
            <button type="button" class="btn btn-outline-secondary" onclick="changeValue(-1)">-</button>
            <input type="number" name="incline_value" id="incline_value" class="form-control text-center" value="0" min="0" max="20">
            <button type="button" class="btn btn-outline-secondary" onclick="changeValue(1)">+</button>
        </div>
    </div>

    <!-- Recovery Interval (Placed beside Incline % as requested) -->
    <div class="col-md-6 mb-3">
        {!! Form::label('recovery_interval', 'Recovery Interval:', ['class' => 'form-label fw-bold']) !!}
        <div class="d-flex gap-2 align-items-center">
            {!! Form::number('recovery_minutes', null, ['class' => 'form-control text-center', 'style' => 'max-width: 80px;', 'min' => 0, 'placeholder' => 'Min']) !!}
            <span>:</span>
            {!! Form::number('recovery_seconds', null, ['class' => 'form-control text-center', 'style' => 'max-width: 80px;', 'min' => 0, 'max' => 59, 'placeholder' => 'Sec']) !!}
        </div>
    </div>

    <!-- Hidden Input to Store Final Incline/Decline Value -->
    <input type="hidden" name="incline" id="final_incline" value="0">


    <!-- Buttons -->
    <div class="col-12 d-flex justify-content-center mt-4">
        <a href="{{ route('tpelogs.index') }}" class="btn btn-outline-dark px-4 py-2 me-3">Cancel</a>
        <button type="submit" class="btn btn-primary px-4 py-2">Save</button>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".increase-btn").forEach(button => {
            button.addEventListener("click", function () {
                let field = this.getAttribute("data-field");
                let input = document.getElementById(field);
                if (input) {
                    input.value = parseInt(input.value) + 1;
                }
            });
        });

        document.querySelectorAll(".decrease-btn").forEach(button => {
            button.addEventListener("click", function () {
                let field = this.getAttribute("data-field");
                let input = document.getElementById(field);
                if (input) {
                    let newValue = parseInt(input.value) - 1;
                    if (newValue < 0) newValue = 0; // Prevent going below 1
                    input.value = newValue;
                }
            });
        });
    });

    function updateMinutes(value) {
        document.getElementById("minutes-display").innerText = value + " minutes";
    }
</script>
<style>

/* Form Inputs & Selects */
.form-control, 
.form-select {
    background-color: #FFF7ED !important; /* Soft Beige */
    color: #333;
    padding: 10px;
    font-size: 16px;
    border-radius: 8px;
}

/* Focus Effect for Inputs */
.form-control:focus, 
.form-select:focus {
    box-shadow: 0 0 8px rgba(168, 92, 3, 0.5);
}

/* Save Button */
.btn-primary {
    background-color: #C96E04 !important; /* Warm Orange */
    border: none;
    color: white !important;
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 16px;
    transition: 0.3s;
}

/* Save Button Hover */
.btn-primary:hover {
    background-color: #A85C03 !important; /* Dark Orange */
}

.form-range::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    background: #C96E04; /* Warm Orange */
    cursor: pointer;
    border-radius: 50%;
}

/* Radio Buttons */
.form-check-input {
    border: 2px solid #8B5E3C !important; /* Dark Brown */
}

/* Radio Button Checked */
.form-check-input:checked {
    background-color: #C96E04 !important; /* Warm Orange */
    border-color: #A85C03 !important;
}

/* Number Input Buttons (Increase/Decrease) */
.btn-outline-secondary {
    border: 2px solid #8B5E3C !important; /* Dark Brown */
    color: #8B5E3C !important;
}

.btn-outline-secondary:hover {
    background-color: #8B5E3C !important;
    color: white !important;
}

/* Table Rows */
.table tbody tr {
    background-color: #FFF7ED !important; /* Soft Beige */
}
/* Minutes Display */
#minutes-display {
    color: #8B5E3C !important; /* Dark Brown */
}

/* Times Per Week Buttons */
.btn-outline-primary {
    color: #8B5E3C !important; /* Dark Brown */
    border-color: #8B5E3C !important;
}

.btn-outline-primary:hover,
.btn-check:checked + .btn-outline-primary {
    background-color: #8B5E3C !important;
    color: white !important;
}
</style>



