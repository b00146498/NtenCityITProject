@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
<<<<<<< HEAD
            Add new Client Profile
=======
            Create Client
>>>>>>> 055b33d67dd55b97234065329410eab37669e986
        </h1>
    </section>
    <div class="content">
        @include('basic-template::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'clients.store']) !!}

                        @include('clients.fields')

                        

                     

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
