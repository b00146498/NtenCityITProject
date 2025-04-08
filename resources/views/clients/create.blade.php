@extends('layouts.app')

@section('content')
    <section class="content-header">

    <div class="d-flex align-items-center mb-4">
        <div class="icon-circle bg-info-subtle text-info me-3">
            <img src="{{ asset('clients.png') }}" alt="Add Client" class="progress-icon">
        </div>
        <h3> Create Client Profile</h3>
    </div>

    </section>
    <div class="content">
        @include('basic-template::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'clients.store']) !!}

                        @include('clients.fields')
                        
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <style>
    h1, h2, h3, h4, h5, h6 {
        font-weight: bold !important;
        font-size: 2rem !important; /* Adjust size */
    }
    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        font-size: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff8e1;
        border: 2px solid #e0c36c;
        color: #a68c30;
    }

    .progress-icon {
        width: 42px;
        height: 42px;
        object-fit: contain;
    }
    </style>
@endsection