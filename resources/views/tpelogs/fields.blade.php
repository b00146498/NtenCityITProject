<!-- Plan Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('plan_id', 'Plan Id:') !!}
    {!! Form::number('plan_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Exercise Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('exercise_id', 'Exercise Id:') !!}
    {!! Form::number('exercise_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Num Sets Field -->
<div class="form-group col-sm-6">
    {!! Form::label('num_sets', 'Num Sets:') !!}
    {!! Form::number('num_sets', null, ['class' => 'form-control']) !!}
</div>

<!-- Num Reps Field -->
<div class="form-group col-sm-6">
    {!! Form::label('num_reps', 'Num Reps:') !!}
    {!! Form::number('num_reps', null, ['class' => 'form-control']) !!}
</div>

<!-- Minutes Field -->
<div class="form-group col-sm-6">
    {!! Form::label('minutes', 'Minutes:') !!}
    {!! Form::number('minutes', null, ['class' => 'form-control']) !!}
</div>

<!-- Intensity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('intensity', 'Intensity:') !!}
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
