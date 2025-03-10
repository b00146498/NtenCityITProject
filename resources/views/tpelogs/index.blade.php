@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Training Plan Exercises/Workout Logs/Exercise Assignments</h1><br>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('tpelogs.create') !!}">Add New</a>
        </h1>
    </section>
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
