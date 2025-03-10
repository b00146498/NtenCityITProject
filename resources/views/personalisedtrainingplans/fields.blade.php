<div class="col-md-6 mb-3">
    {!! Form::label('client_id', 'Client:', ['class' => 'form-label fw-bold']) !!}
    <select name="client_id" class="form-select">
        <option value="" selected disabled>Select a Client</option>
        @foreach($clients as $client)
            <option value="{{ $client->id }}">
                {{ $client->first_name }} {{ $client->surname }}
            </option>
        @endforeach
    </select>
</div>

<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', 'Start Date:') !!}
    {!! Form::date('start_date', null, ['class' => 'form-control']) !!}
</div>

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'End Date:') !!}
    {!! Form::date('end_date', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('personalisedtrainingplans.index') !!}" class="btn btn-default">Cancel</a>
</div>
