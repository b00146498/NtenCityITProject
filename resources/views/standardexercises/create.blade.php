@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-white d-flex justify-content-between">
            <h4 class="fw-bold">Create Standard Exercise</h4>
            <a href="{{ route('standardexercises.index') }}" class="text-white text-decoration-none fw-bold">✖ Close</a>
        </div>
        <div class="card-body">
            @include('basic-template::common.errors')

            {!! Form::open(['route' => 'standardexercises.store']) !!}

            @include('standardexercises.fields')

            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

