@extends('layouts.app')

@section('content')
<div class="container mt-1">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h4>Edit Employee Details</h4>
            <a href="{{ route('employees.index') }}" class="text-white text-decoration-none">✖ Close</a>
        </div>
        <div class="card-body">
            @include('basic-template::common.errors')

            {!! Form::model($employee, ['route' => ['employees.update', $employee->id], 'method' => 'patch']) !!}
            
            @include('employees.fields')

            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
