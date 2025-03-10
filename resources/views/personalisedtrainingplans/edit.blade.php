@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            personalisedtrainingplan
        </h1>
    </section>
    <div class="content">
       @include('basic-template::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($personalisedtrainingplan, ['route' => ['personalisedtrainingplans.update', $personalisedtrainingplan->id], 'method' => 'patch']) !!}

                        @include('personalisedtrainingplans.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
    </div>
@endsection