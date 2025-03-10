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

<!-- Num Sets Field -->
<div class="form-group col-sm-6">
    {!! Form::label('num_sets', 'Number of Sets:') !!}
    {!! Form::number('num_sets', null, ['class' => 'form-control']) !!}
</div>

<!-- Num Reps Field -->
<div class="form-group col-sm-6">
    {!! Form::label('num_reps', 'Number of Reps:') !!}
    {!! Form::number('num_reps', null, ['class' => 'form-control']) !!}
</div>

<!-- Minutes Field -->
<div class="form-group col-sm-6">
    {!! Form::label('minutes', 'Minutes:') !!}
    {!! Form::number('minutes', null, ['class' => 'form-control']) !!}
</div>

<!-- Intensity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('intensity', 'Intensity Level:') !!}
    {!! Form::text('intensity', null, ['class' => 'form-control']) !!}
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


