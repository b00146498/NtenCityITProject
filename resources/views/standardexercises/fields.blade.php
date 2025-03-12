<!-- Exercise Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('exercise_name', 'Exercise Name:') !!}
    {!! Form::text('exercise_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Exercise Video Link Field -->
<div class="form-group col-sm-6">
    {!! Form::label('exercise_video_link', 'Exercise Video Link:') !!}
    {!! Form::text('exercise_video_link', null, ['class' => 'form-control']) !!}
</div>

<!-- Target Body Area Field -->
<div class="form-group col-sm-6">
    {!! Form::label('target_body_area', 'Target Body Area:') !!}
    {!! Form::text('target_body_area', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('standardexercises.index') !!}" class="btn btn-default">Cancel</a>
</div>


