@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h4>Edit Employee Details</h4>
            <a href="{{ route('employees.index') }}" class="text-white text-decoration-none">✖ Close</a>
        </div>
        <div class="card-body">
            @include('basic-template::common.errors')

            {!! Form::model($employee, ['route' => ['employees.update', $employee->id], 'method' => 'patch']) !!}
            
            @include('employees.fields')

            <!-- Submit Button Section -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('employees.index') }}" class="btn btn-outline-dark px-4 py-2">Cancel</a>
                {!! Form::submit('Save Changes', ['class' => 'btn btn-success px-4 py-2']) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
