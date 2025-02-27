@extends('layouts.app')

@section('content')
<div class="container mt-1">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h1>
            Edit Client Details
            </h1>
            <a href="{{ route('clients.index') }}" class="text-white text-decoration-none">✖ Close</a>
        </div>
        <div class="card-body">
            @include('basic-template::common.errors')
       
            {!! Form::model($client, ['route' => ['clients.update', $client->id], 'method' => 'patch']) !!}

            @include('clients.fields')

            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

