@extends('layouts.app')

@section('content')
    <section class="content-header">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <h1 class="pull-left">Client Profiles</h1>
        <h1 class="pull-right">
            <h1 class="pull-right" style="display: flex; justify-content: flex-end;">
                <a href="{{ route('clients.create') }}" class="btn btn-primary" 
<<<<<<< HEAD
                    style="background-color: #C96E04; border-color: #C96E04; color: white;">
=======
                   style="background-color: #C96E04; border-color: #C96E04; color: white;">
>>>>>>> 055b33d67dd55b97234065329410eab37669e986
                    <i class="glyphicon glyphicon-plus"></i> New Client
                </a>
            </h1>
        </h1>
    </section>
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
@endsection

