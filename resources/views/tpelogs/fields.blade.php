<!-- Plan Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('plan_id', 'Training Plan:') !!}
    {!! Form::number('plan_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Exercise Dropdown -->
<div class="form-group col-sm-6">
    {!! Form::label('exercise_id', 'Exercise:', ['class' => 'form-label fw-bold']) !!}
    <select name="exercise_id" class="form-select">
        <option value="" selected disabled>Select an Exercise</option>
        @foreach($exercises as $exercise)
            <option value="{{ $exercise->id }}">
                {{ $exercise->exercise_name }}
            </option>
        @endforeach
    </select>
</div>

<!-- Number of Sets with Increment/Decrement -->
<div class="form-group col-sm-6">
    {!! Form::label('num_sets', 'Number of Sets:', ['class' => 'form-label fw-bold']) !!}
    <div class="input-group">
        <button type="button" class="btn btn-outline-secondary decrease-btn" data-field="num_sets">-</button>
        <input type="number" name="num_sets" id="num_sets" class="form-control text-center" value="{{ old('num_sets', 1) }}" min="1">
        <button type="button" class="btn btn-outline-secondary increase-btn" data-field="num_sets">+</button>
    </div>
</div>

<!-- Number of Reps with Increment/Decrement -->
<div class="form-group col-sm-6">
    {!! Form::label('num_reps', 'Number of Reps:', ['class' => 'form-label fw-bold']) !!}
    <div class="input-group">
        <button type="button" class="btn btn-outline-secondary decrease-btn" data-field="num_reps">-</button>
        <input type="number" name="num_reps" id="num_reps" class="form-control text-center" value="{{ old('num_reps', 10) }}" min="1">
        <button type="button" class="btn btn-outline-secondary increase-btn" data-field="num_reps">+</button>
    </div>
</div>

<!-- Minutes Field -->
<div class="form-group col-sm-6">
    {!! Form::label('minutes', 'Minutes:') !!}
    {!! Form::number('minutes', null, ['class' => 'form-control']) !!}
</div>

<!-- Intensity Dropdown -->
<div class="form-group col-sm-6">
    {!! Form::label('intensity', 'Intensity Level:', ['class' => 'form-label fw-bold']) !!}
    <select name="intensity" class="form-select">
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
        <input type="radio" name="incline_type" id="incline_option" value="incline" class="form-check-input" checked>
        <label for="incline_option" class="ms-2">Incline</label>

        <input type="radio" name="incline_type" id="decline_option" value="decline" class="form-check-input ms-4">
        <label for="decline_option" class="ms-2">Decline</label>
    </div>
</div>

<!-- Incline/Decline Percentage Input -->
<div class="form-group col-sm-6">
    {!! Form::label('incline_value', 'Incline/Decline Percentage:', ['class' => 'form-label fw-bold']) !!}
    <div class="input-group">
        <button type="button" class="btn btn-outline-secondary" onclick="changeValue(-1)">-</button>
        <input type="number" name="incline_value" id="incline_value" class="form-control text-center" value="0" min="0" max="20">
        <button type="button" class="btn btn-outline-secondary" onclick="changeValue(1)">+</button>
    </div>
</div>

<!-- Hidden Input to Store Final Incline/Decline Value -->
<input type="hidden" name="incline" id="final_incline" value="0">

<!-- Times Per Week Field -->
<div class="form-group col-sm-6">
    {!! Form::label('times_per_week', 'Times Per Week:') !!}
    {!! Form::number('times_per_week', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('tpelogs.index') !!}" class="btn btn-default">Cancel</a>
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
</script>
