@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            practice
        </h1>
    </section>
    <div class="content">
       @include('basic-template::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($practice, ['route' => ['practices.update', $practice->id], 'method' => 'patch']) !!}

                        @include('practices.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
    </div>
@endsection