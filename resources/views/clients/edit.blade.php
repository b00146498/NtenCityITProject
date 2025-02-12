@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Edit Client
        </h1>
    </section>
    <div class="content">
       @include('basic-template::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($client, ['route' => ['clients.update', $client->id], 'method' => 'patch']) !!}

                        @include('clients.fields')

                        <!-- Practice Dropdown -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('practice_id', 'Practice:') !!}
                            <select name="practice_id" class="form-control">
                                @foreach($practices as $practice)
                                    <option value="{{ $practice->id }}" {{ $client->practice_id == $practice->id ? 'selected' : '' }}>
                                        {{ $practice->company_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
                            <a href="{{ route('clients.index') }}" class="btn btn-default">Cancel</a>
                        </div>

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
    </div>
@endsection
