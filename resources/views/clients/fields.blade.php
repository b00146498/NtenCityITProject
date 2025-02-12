<div class="row">
    <!-- First Name Field -->
    <div class="form-group col-md-6">
        {!! Form::label('first_name', 'First Name:') !!}
        {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Surname Field -->
    <div class="form-group col-md-6">
        {!! Form::label('surname', 'Surname:') !!}
        {!! Form::text('surname', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="row">
    <!-- Date Of Birth Field -->
    <div class="form-group col-md-6">
        {!! Form::label('date_of_birth', 'Date Of Birth:') !!}
        {!! Form::date('date_of_birth', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Gender Field -->
    <div class="form-group col-md-6">
        {!! Form::label('gender', 'Gender:') !!}
        {!! Form::select('gender', ['Male' => 'Male', 'Female' => 'Female'], null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="row">
    <!-- Email Field -->
    <div class="form-group col-md-6">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::email('email', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Contact Number Field -->
    <div class="form-group col-md-6">
        {!! Form::label('contact_number', 'Contact Number:') !!}
        {!! Form::text('contact_number', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="row">
    <!-- Street Field -->
    <div class="form-group col-md-6">
        {!! Form::label('street', 'Street:') !!}
        {!! Form::text('street', null, ['class' => 'form-control']) !!}
    </div>

    <!-- City Field -->
    <div class="form-group col-md-6">
        {!! Form::label('city', 'City:') !!}
        {!! Form::text('city', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="row">
    <!-- County Field -->
    <div class="form-group col-md-6">
        {!! Form::label('county', 'County:') !!}
        {!! Form::text('county', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Username Field -->
    <div class="form-group col-md-6">
        {!! Form::label('username', 'Username:') !!}
        {!! Form::text('username', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="row">
    <!-- Password Field -->
    <div class="form-group col-md-6">
        {!! Form::label('password', 'Password:') !!}
        {!! Form::password('password', ['class' => 'form-control']) !!}
    </div>

    <!-- Account Status Field -->
    <div class="form-group col-md-6">
        {!! Form::label('account_status', 'Account Status:') !!}
        {!! Form::select('account_status', ['Active' => 'Active', 'Inactive' => 'Inactive'], null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="row">
    <!-- Practice Dropdown (Replaces Practice ID) -->
    <div class="form-group col-md-6">
        {!! Form::label('practice_id', 'Practice:') !!}
        <select name="practice_id" class="form-control">
            @foreach($practices as $practice)
                <option value="{{ $practice->id }}">{{ $practice->company_name }}</option>
            @endforeach
        </select>
    </div>
</div>

<!-- Submit Field -->
<div class="row">
    <div class="form-group col-md-12">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('clients.index') !!}" class="btn btn-default">Cancel</a>
    </div>
</div>
