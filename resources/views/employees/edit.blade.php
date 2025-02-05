@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            employee
        </h1>
    </section>
    <div class="content">
       @include('basic-template::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($employee, ['route' => ['employees.update', $employee->id], 'method' => 'patch']) !!}

                        @include('employees.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
    </div>
@endsection