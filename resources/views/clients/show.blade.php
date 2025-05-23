@extends('layouts.app')

@section('content')
<div class="container mt-1">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h4>View Client Details</h4>
            <a href="{{ route('clients.index') }}" class="text-white text-decoration-none">✖ Close</a>
        </div>
        <div class="card-body">
            @include('clients.show_fields') 

            <div class="d-flex justify-content-end mt-3">
                <a href="{!! route('clients.index') !!}" class="btn btn-outline-dark px-4 py-2">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection