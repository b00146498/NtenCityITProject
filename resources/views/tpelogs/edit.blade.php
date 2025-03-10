@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            tpelog
        </h1>
    </section>
    <div class="content">
       @include('basic-template::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($tpelog, ['route' => ['tpelogs.update', $tpelog->id], 'method' => 'patch']) !!}

                        @include('tpelogs.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
    </div>
@endsection