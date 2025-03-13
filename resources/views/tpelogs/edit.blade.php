@extends('layouts.app')

@section('content')
<div class="container mt-1">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-white d-flex justify-content-between">
            <h4 class="fw-bold">Edit Workout Log</h4>
            <a href="{{ route('tpelogs.index') }}" class="text-white text-decoration-none fw-bold">✖ Close</a>
        </div>
        <div class="card-body">
            @include('basic-template::common.errors')

            {!! Form::model($tpelog, ['route' => ['tpelogs.update', $tpelog->id], 'method' => 'patch']) !!}

            @include('tpelogs.fields')

            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
