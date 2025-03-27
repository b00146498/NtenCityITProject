@extends('layouts.mobile')

@section('content')

<!-- Dashboard Header -->
<div class="dashboard-header px-3 py-2 d-flex justify-content-between align-items-center">
    <img src="{{ asset('ntencitylogo.png') }}" alt="Ntencity Logo" class="logo">

    @auth
        <div class="user-info">
            {{ Auth::user()->name }} <i class="fas fa-user ms-2"></i>
        </div>
    @endauth
</div>

<div class="container pb-5 pt-3">
    <h2 class="text-center mb-4">Edit Profile</h2>

    @include('basic-template::common.errors')

    {!! Form::model($client, ['route' => ['clients.update', $client->id], 'method' => 'patch']) !!}

    <div class="row g-3">
        <div class="col-12">
            {!! Form::label('first_name', 'First Name:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::text('first_name', null, ['class' => 'form-control', 'required']) !!}
        </div>

        <div class="col-12">
            {!! Form::label('surname', 'Surname:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::text('surname', null, ['class' => 'form-control', 'required']) !!}
        </div>

        <div class="col-12">
            {!! Form::label('date_of_birth', 'Date of Birth:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::date('date_of_birth', null, ['class' => 'form-control', 'required']) !!}
        </div>

        <div class="col-12">
            {!! Form::label('gender', 'Gender:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::select('gender', ['Male' => 'Male', 'Female' => 'Female'], null, ['class' => 'form-select', 'placeholder' => 'Select Gender', 'required']) !!}
        </div>

        <div class="col-12">
            {!! Form::label('email', 'Email:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
        </div>

        <div class="col-12">
            {!! Form::label('contact_number', 'Contact Number:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::text('contact_number', null, ['class' => 'form-control', 'required']) !!}
        </div>

        <div class="col-12">
            {!! Form::label('street', 'Street:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::text('street', null, ['class' => 'form-control']) !!}
        </div>

        <div class="col-12">
            {!! Form::label('city', 'City:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::text('city', null, ['class' => 'form-control']) !!}
        </div>

        <div class="col-12">
            {!! Form::label('county', 'County:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::text('county', null, ['class' => 'form-control']) !!}
        </div>

        <div class="col-12">
            {!! Form::label('username', 'Username:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::text('username', null, ['class' => 'form-control', 'required']) !!}
        </div>

        <div class="col-12">
            {!! Form::label('password', 'Password (must fill in):', ['class' => 'form-label fw-bold']) !!}
            {!! Form::password('password', ['class' => 'form-control']) !!}
        </div>

        <div class="col-12">
            {!! Form::label('account_status', 'Account Status:', ['class' => 'form-label fw-bold']) !!}
            {!! Form::select('account_status', ['Active' => 'Active', 'Inactive' => 'Inactive'], null, ['class' => 'form-select', 'required']) !!}
        </div>

        <div class="col-12">
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

    <div class="d-grid mt-4">
        <button type="submit" class="btn btn-primary btn-lg">Save Details</button>
    </div>

    {!! Form::close() !!}
</div>

<!-- Bottom Navigation -->
<nav class="bottom-nav">
    <a href="{{ url('/client/clientdashboard') }}" class="nav-item"><i class="fas fa-home"></i></a>
    <a href="{{ url('/progress') }}" class="nav-item"><i class="fas fa-list"></i></a>
    <a href="{{ url('/appointments') }}" class="nav-item"><i class="fas fa-clock"></i></a>
    <a href="{{ url('/workoutlogs') }}" class="nav-item"><i class="far fa-check-circle"></i></a>
    <a href="{{ url('/alerts') }}" class="nav-item"><i class="fas fa-comment"></i></a>
    <a href="{{ url('/clientprofile') }}" class="nav-item active"><i class="fas fa-user"></i></a>
</nav>

@endsection

<style>
.logo {
    width: 135px;
    height: auto;
}

.user-info {
    display: flex;
    align-items: center;
    font-weight: bold;
}

.user-info i {
    font-size: 18px;
    margin-left: 6px;
}

/* Bottom Navigation */
.bottom-nav {
    position: fixed;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    max-width: 400px;
    background: white;
    display: flex;
    justify-content: space-around;
    padding: 12px 0;
    box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
    border-top: 1px solid #ccc;
    z-index: 1000;
    border-radius: 0 0 15px 15px;
}

.nav-item {
    color: #666;
    font-size: 18px;
    text-align: center;
    text-decoration: none;
}

.nav-item.active {
    color: #C96E04;
}
</style>
