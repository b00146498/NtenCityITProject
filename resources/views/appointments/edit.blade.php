@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Appointment
        </h1>
    </section>
    <div class="content">
       @include('basic-template::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($appointment, ['route' => ['appointments.update', $appointment->id], 'method' => 'patch']) !!}

                        @include('appointments.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
    </div>
@endsection