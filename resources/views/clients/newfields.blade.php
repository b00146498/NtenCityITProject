@section('content')
<div style="display: flex; justify-content: center; align-items: center; min-height: 100vh;">

    <div>
        <section class="content-header">
            <h2 class="text-center" style="font-weight: bold; margin-bottom: 15px; color: #AD8A18;">Create Account</h2>
        </section>

        <div class="mobile-container">
            @include('basic-template::common.errors')

            {!! Form::open(['route' => 'clients.store']) !!}
        <input type="hidden" name="userid" value="{{ $userid }}"/>
        <div class="row">

        <!-- First Name -->
        <div class="col-12 mb-3">
            {!! Form::label('first_name', 'First Name:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::text('first_name', null, ['class' => 'form-control', 'required']) !!}
        </div>

        <!-- Surname -->
        <div class="col-12 mb-3">
            {!! Form::label('surname', 'Surname:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::text('surname', null, ['class' => 'form-control', 'required']) !!}
        </div>

        <!-- Date of Birth -->
        <div class="col-12 mb-3">
            {!! Form::label('date_of_birth', 'Date of Birth:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::date('date_of_birth', null, ['class' => 'form-control', 'required']) !!}
        </div>

        <!-- Gender -->
        <div class="col-12 mb-3">
            {!! Form::label('gender', 'Gender:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::select('gender', ['Male' => 'Male', 'Female' => 'Female'], null, ['class' => 'form-select', 'placeholder' => 'Select Gender', 'required']) !!}
        </div>

        <!-- Email -->
        <div class="col-12 mb-3">
            {!! Form::label('email', 'Email:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'example@gmail.com', 'required']) !!}
        </div>

        <!-- Contact Number -->
        <div class="col-12 mb-3">
            {!! Form::label('contact_number', 'Contact Number:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::text('contact_number', null, ['class' => 'form-control', 'placeholder' => '(xxx) xxx xxxx', 'required']) !!}
        </div>

        <!-- Street -->
        <div class="col-12 mb-3">
            {!! Form::label('street', 'Street:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::text('street', null, ['class' => 'form-control']) !!}
        </div>

        <!-- City -->
        <div class="col-12 mb-3">
            {!! Form::label('city', 'City:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::text('city', null, ['class' => 'form-control']) !!}
        </div>

        <!-- County -->
        <div class="col-12 mb-3">
            {!! Form::label('county', 'County:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::text('county', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Username -->
        <div class="col-12 mb-3">
            {!! Form::label('username', 'Username:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::text('username', null, ['class' => 'form-control', 'required']) !!}
        </div>

        <!-- Password -->
        <div class="col-12 mb-3">
            {!! Form::label('password', 'Password (must fill in):', ['class' => 'form-label fw-bold']) !!}
            {!! Form::password('password', ['class' => 'form-control']) !!}
        </div>

        <!-- Account Status (Optional) -->
        {{-- Remove this block if you don’t want to keep account status --}}
        <div class="col-12 mb-3">
            {!! Form::label('account_status', 'Account Status:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::select('account_status', ['Active' => 'Active', 'Inactive' => 'Inactive'], null, ['class' => 'form-select', 'required']) !!}
        </div>

        <!-- Practice -->
        <div class="col-12 mb-3">
            {!! Form::label('practice_id', 'Practice:', ['class' => 'form-label fw-bold']) !!}
            <select name="practice_id" class="form-select" required>
                @foreach($practices as $practice)
                    <option value="{{ $practice->id }}">{{ $practice->company_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Save/Cancel -->
        <div class="form-group col-12 mt-2">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            <a href="{!! route('clients.index') !!}" class="btn btn-default">Cancel</a>
        </div>

    </div>
</div>


<style>
    /* Heading Styles */
    h1, h2, h3, h4, h5, h6 {
        font-weight: bold !important;
        font-size: 2rem !important; /* Adjust size */
    }

    /* Common Button Styles (Back & Update) */
    .btn-primary {
        background-color: #C96E04 !important; /* Orange */
        color: white !important;
        font-weight: bold;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 15px;
        transition: 0.3s;
        text-decoration: none;
    }
    .mobile-container {
        max-width: 370px;
        width: 100%;
        margin: 0 auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    /* Hover Effect */
    .btn-primary:hover {
        background-color: #A85C03 !important; /* Darker Orange */
    }
    .form-control {
        background-color: #FFF7ED !important;
    }
    
</style>

@endsection