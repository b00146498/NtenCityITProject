<div class="container">
    <div class="row">
        @foreach($standardexercises as $exercise)
        <div class="col-md-4 mb-4"> 
            <div class="card shadow-lg">
                <div class="card-body">
                    <h4 class="card-title fw-bold">{{ $exercise->exercise_name }}</h4>
                    <p class="mb-1"><strong>Target Area:</strong> {{ $exercise->target_body_area }}</p>

                    @if ($exercise->exercise_video_link)
                        <div class="embed-responsive embed-responsive-16by9 mb-2">
                            <iframe class="embed-responsive-item" src="{{ $exercise->exercise_video_link }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @else
                        <p class="text-muted">No video available</p>
                    @endif
                
                    <div class="d-flex justify-content-center mt-3">
                        <a href="{{ route('standardexercises.show', $exercise->id) }}" class="btn btn-outline-secondary btn-sm mx-1 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('standardexercises.edit', $exercise->id) }}" class="btn btn-outline-primary btn-sm mx-1 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::open(['route' => ['standardexercises.destroy', $exercise->id], 'method' => 'delete', 'onsubmit' => "return confirm('Are you sure?')", 'class' => 'd-inline']) !!}
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-outline-danger btn-sm mx-1 d-flex align-items-center justify-content-center',
                                'style' => 'width: 36px; height: 36px;'
                            ]) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<style>
    h1, h2, h3, h4, h5, h6 {
        font-weight: bold !important;
        font-size: 2rem !important; /* Adjust size */
    }
</style>


