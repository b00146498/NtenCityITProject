<div class="row">
    <!-- Training Plan -->
    <div class="col-md-6 mb-3">
        {!! Form::label('plan_id', 'Training Plan:', ['class' => 'form-label fw-bold']) !!}
        {!! Form::number('plan_id', null, ['class' => 'form-control bg-light']) !!}
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
            <input type="number" name="num_sets" id="num_sets" class="form-control text-center bg-light" value="{{ old('num_sets', 1) }}" min="1">
            <button type="button" class="btn btn-outline-secondary increase-btn" data-field="num_sets">+</button>
        </div>
    </div>

    <!-- Number of Reps -->
    <div class="col-md-6 mb-3">
        {!! Form::label('num_reps', 'Number of Reps:', ['class' => 'form-label fw-bold']) !!}
        <div class="input-group">
            <button type="button" class="btn btn-outline-secondary decrease-btn" data-field="num_reps">-</button>
            <input type="number" name="num_reps" id="num_reps" class="form-control text-center bg-light" value="{{ old('num_reps', 10) }}" min="1">
            <button type="button" class="btn btn-outline-secondary increase-btn" data-field="num_reps">+</button>
        </div>
    </div>

    <!-- Minutes -->
    <div class="col-md-6 mb-3">
        {!! Form::label('minutes', 'Minutes:', ['class' => 'form-label fw-bold']) !!}
        <div class="text-center">
            <input type="range" name="minutes" id="minutes" class="form-range" min="1" max="120" value="{{ old('minutes', 30) }}" oninput="updateMinutes(this.value)">
            <h4 id="minutes-display" class="fw-bold mt-2 text-primary">{{ old('minutes', 30) }} min</h4>
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
    <div class="col-md-6 mb-3">
        {!! Form::label('incline_type', 'Incline or Decline:', ['class' => 'form-label fw-bold']) !!}
        <div class="d-flex align-items-center">
            <input type="radio" name="incline_type" id="none_option" value="none" class="form-check-input" checked>
            <label for="none_option" class="ms-2">None</label>

            <input type="radio" name="incline_type" id="incline_option" value="incline" class="form-check-input ms-4">
            <label for="incline_option" class="ms-2">Incline</label>

            <input type="radio" name="incline_type" id="decline_option" value="decline" class="form-check-input ms-4">
            <label for="decline_option" class="ms-2">Decline</label>
        </div>
    </div>

    <!-- Times Per Week -->
    <div class="col-md-6 mb-3">
        {!! Form::label('times_per_week', 'Times Per Week:', ['class' => 'form-label fw-bold']) !!}
        <div class="btn-group w-100" role="group">
            @for ($i = 1; $i <= 7; $i++)
                <input type="radio" class="btn-check" name="times_per_week" id="week_{{ $i }}" value="{{ $i }}">
                <label class="btn btn-outline-primary" for="week_{{ $i }}">{{ $i }}</label>
            @endfor
        </div>
    </div>

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
                    if (newValue < 1) newValue = 1; // Prevent going below 1
                    input.value = newValue;
                }
            });
        });
    });

    function updateMinutes(value) {
        document.getElementById("minutes-display").innerText = value + " minutes";
    }
</script>



