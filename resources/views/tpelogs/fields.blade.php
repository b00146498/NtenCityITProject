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

<<!-- Number of Sets with Increment/Decrement -->
<div class="form-group col-sm-6">
    {!! Form::label('num_sets', 'Number of Sets:', ['class' => 'form-label fw-bold']) !!}
    <div class="input-group">
        <button type="button" class="btn btn-outline-secondary" onclick="changeValue('num_sets', -1)">-</button>
        <input type="text" name="num_sets" id="num_sets" class="form-control text-center" value="1" readonly>
        <button type="button" class="btn btn-outline-secondary" onclick="changeValue('num_sets', 1)">+</button>
    </div>
</div>

<!-- Number of Reps with Increment/Decrement -->
<div class="form-group col-sm-6">
    {!! Form::label('num_reps', 'Number of Reps:', ['class' => 'form-label fw-bold']) !!}
    <div class="input-group">
        <button type="button" class="btn btn-outline-secondary" onclick="changeValue('num_reps', -1)">-</button>
        <input type="text" name="num_reps" id="num_reps" class="form-control text-center" value="10" readonly>
        <button type="button" class="btn btn-outline-secondary" onclick="changeValue('num_reps', 1)">+</button>
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

<!-- Incline Field -->
<div class="form-group col-sm-6">
    {!! Form::label('incline', 'Incline:') !!}
    {!! Form::number('incline', null, ['class' => 'form-control']) !!}
</div>

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


