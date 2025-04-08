@extends('layouts.app')

@section('content')
    <section class="content-header">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <div class="row">
            <div class="col-sm-6 d-flex" style="display: flex; align-items: center;">
                <div class="icon-circle bg-info-subtle text-info" style="margin-right: 15px;">
                    <img src="{{ asset('clientprofile.png') }}" alt="Client Profiles" class="progress-icon">
                </div>
                <h1 class="m-0">Client Profiles</h1>
            </div>

            <div class="col-sm-6 text-right">
                <a href="{{ route('clients.create') }}" class="btn btn-primary" 
                    style="background-color: #C96E04; border-color: #C96E04; color: white; margin-top: 10px;">
                    <i class="glyphicon glyphicon-plus"></i> New Clients
                </a>
            </div>
        </div>
    </section><br>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('clients.table')
            </div>
        </div>
    </div>
    <style>
    h1, h2, h3, h4, h5, h6 {
        font-weight: bold !important;
        font-size: 3rem !important; /* Adjust size */
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

