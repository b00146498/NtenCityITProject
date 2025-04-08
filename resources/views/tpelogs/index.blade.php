@extends('layouts.app')
@section('content')
    <section class="content-header container">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-6 d-flex align-items-center">
                <div class="icon-circle bg-info-subtle text-info me-3">
                    <img src="{{ asset('plan.png') }}" alt="Workout Logs" class="progress-icon">
                </div>
                <h1 class="mb-0">Workout Logs</h1>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('tpelogs.create') }}" class="btn btn-primary"
                   style="background-color: #C96E04; border-color: #C96E04; color: white;">
                    <i class="glyphicon glyphicon-plus"></i> Add New Workout Log
                </a>
            </div>
        </div>
    </section>
    <br>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('tpelogs.table')
            </div>
        </div>
    </div>
@endsection
<style>
    h1, h2, h3, h4, h5, h6 {
        font-weight: bold !important;
        font-size: 2rem !important; /* Adjust size */
    }
    .icon-circle {
        width: 50px;
        height: 50px;
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
        width: 32px;
        height: 32px;
        object-fit: contain;
    }
</style>
