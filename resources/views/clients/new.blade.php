@extends('layouts.mobile')

@section('content')
    <section class="content-header">
        <h2 class="text-center" style="font-weight: bold; margin-bottom: 15px; color: #AD8A18;">Create Account</h2>
    </section>
    <div class="content">
        @include('basic-template::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'clients.store']) !!}

                        @include('clients.newfields')
                        
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection