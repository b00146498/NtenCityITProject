@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            customer
        </h1>
    </section>
    <div class="content">
        @include('basic-template::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'customers.store']) !!}

                        @include('customers.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
