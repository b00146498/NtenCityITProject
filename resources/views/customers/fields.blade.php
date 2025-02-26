<!-- Firstname Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('firstname', 'Firstname:') !!}
    {!! Form::textarea('firstname', null, ['class' => 'form-control']) !!}
</div>

<!-- Surname Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('surname', 'Surname:') !!}
    {!! Form::textarea('surname', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('customers.index') !!}" class="btn btn-default">Cancel</a>
</div>
