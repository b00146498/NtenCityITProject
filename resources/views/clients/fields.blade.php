<div class="row">
    <!-- First Name -->
    <div class="col-md-6 mb-3">
        {!! Form::label('first_name', 'First Name:', ['class' => 'form-label fw-bold']) !!}
        {!! Form::text('first_name', null, ['class' => 'form-control', 'required']) !!}
    </div>

    <!-- Surname -->
    <div class="col-md-6 mb-3">
        {!! Form::label('surname', 'Surname:', ['class' => 'form-label fw-bold']) !!}
        {!! Form::text('surname', null, ['class' => 'form-control', 'required']) !!}
    </div>

    <!-- Date of Birth -->
    <div class="col-md-6 mb-3">
        {!! Form::label('date_of_birth', 'Date of Birth:', ['class' => 'form-label fw-bold']) !!}
        {!! Form::date('date_of_birth', null, ['class' => 'form-control', 'required']) !!}
    </div>

    <!-- Gender -->
    <div class="col-md-6 mb-3">
        {!! Form::label('gender', 'Gender:', ['class' => 'form-label fw-bold']) !!}
        {!! Form::select('gender', ['Male' => 'Male', 'Female' => 'Female'], null, ['class' => 'form-select', 'placeholder' => 'Select Gender', 'required']) !!}
    </div>

    <!-- Email -->
    <div class="col-md-6 mb-3">
        {!! Form::label('email', 'Email:', ['class' => 'form-label fw-bold']) !!}
        {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
    </div>

    <!-- Contact Number -->
    <div class="col-md-6 mb-3">
        {!! Form::label('contact_number', 'Contact Number:', ['class' => 'form-label fw-bold']) !!}
        {!! Form::text('contact_number', null, ['class' => 'form-control', 'required']) !!}
    </div>

    <!-- Street -->
    <div class="col-md-6 mb-3">
        {!! Form::label('street', 'Street:', ['class' => 'form-label fw-bold']) !!}
        {!! Form::text('street', null, ['class' => 'form-control']) !!}
    </div>

    <!-- City -->
    <div class="col-md-6 mb-3">
        {!! Form::label('city', 'City:', ['class' => 'form-label fw-bold']) !!}
        {!! Form::text('city', null, ['class' => 'form-control']) !!}
    </div>

    <!-- County -->
    <div class="col-md-6 mb-3">
        {!! Form::label('county', 'County:', ['class' => 'form-label fw-bold']) !!}
        {!! Form::text('county', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Username -->
    <div class="col-md-6 mb-3">
        {!! Form::label('username', 'Username:', ['class' => 'form-label fw-bold']) !!}
        {!! Form::text('username', null, ['class' => 'form-control', 'required']) !!}
    </div>

    <!-- Password -->
    <div class="col-md-6 mb-3">
        {!! Form::label('password', 'Password (Leave blank to keep current):', ['class' => 'form-label fw-bold']) !!}
        {!! Form::password('password', ['class' => 'form-control']) !!}
    </div>

    <!-- Account Status -->
    <div class="col-md-6 mb-3">
        {!! Form::label('account_status', 'Account Status:', ['class' => 'form-label fw-bold']) !!}
        {!! Form::select('account_status', ['Active' => 'Active', 'Inactive' => 'Inactive'], null, ['class' => 'form-select', 'required']) !!}
    </div>

    <!-- Practice -->
    <div class="col-md-6 mb-3">
        {!! Form::label('practice_id', 'Practice:', ['class' => 'form-label fw-bold']) !!}
        <select name="practice_id" class="form-select">
            @foreach($practices as $practice)
                <option value="{{ $practice->id }}" {{ $client->practice_id == $practice->id ? 'selected' : '' }}>
                    {{ $practice->company_name }}
                </option>
            @endforeach
        </select>
    </div>
</div>
