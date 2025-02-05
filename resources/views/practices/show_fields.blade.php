<!-- Company Name Field -->
<div class="form-group">
    {!! Form::label('company_name', 'Company Name:') !!}
    <p>{!! $practice->company_name !!}</p>
</div>

<!-- Company Type Field -->
<div class="form-group">
    {!! Form::label('company_type', 'Company Type:') !!}
    <p>{!! $practice->company_type !!}</p>
</div>

<!-- Street Field -->
<div class="form-group">
    {!! Form::label('street', 'Street:') !!}
    <p>{!! $practice->street !!}</p>
</div>

<!-- City Field -->
<div class="form-group">
    {!! Form::label('city', 'City:') !!}
    <p>{!! $practice->city !!}</p>
</div>

<!-- County Field -->
<div class="form-group">
    {!! Form::label('county', 'County:') !!}
    <p>{!! $practice->county !!}</p>
</div>

<!-- Iban Field -->
<div class="form-group">
    {!! Form::label('iban', 'Iban:') !!}
    <p>{!! $practice->iban !!}</p>
</div>

<!-- Bic Field -->
<div class="form-group">
    {!! Form::label('bic', 'Bic:') !!}
    <p>{!! $practice->bic !!}</p>
</div>

