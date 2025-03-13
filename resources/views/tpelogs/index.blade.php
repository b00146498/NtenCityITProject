@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="mb-0">Workout Logs</h1>
            <a href="{!! route('tpelogs.create') !!}" class="btn btn-primary" 
                style="background-color: #C96E04; border-color: #C96E04; color: white;">
                <i class="glyphicon glyphicon-plus"></i> Add New Workout Log
            </a>
        </div>
    </section><br>
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
</style>
