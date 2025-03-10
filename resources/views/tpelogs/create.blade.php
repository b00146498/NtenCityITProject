@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Add new Training Plan Exercises/Workout Logs/Exercise Assignments
        </h1>
    </section>
    <div class="content">
        @include('basic-template::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'tpelogs.store']) !!}

                        @include('tpelogs.fields')

                    {!! Form::close() !!}
                </div>
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
