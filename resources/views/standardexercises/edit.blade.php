@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            standardexercises
        </h1>
    </section>
    <div class="content">
       @include('basic-template::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($standardexercises, ['route' => ['standardexercises.update', $standardexercises->id], 'method' => 'patch']) !!}

                        @include('standardexercises.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
    </div>
@endsection