<div class="row">
    <!-- Exercise Name -->
    <div class="col-md-6 mb-3">
        {!! Form::label('exercise_name', 'Exercise Name:', ['class' => 'form-label fw-bold']) !!}
        {!! Form::text('exercise_name', null, ['class' => 'form-control bg-light', 'required']) !!}
    </div>

    <!-- Exercise Video Link -->
    <div class="col-md-6 mb-3">
        {!! Form::label('exercise_video_link', 'Exercise Video Link:', ['class' => 'form-label fw-bold']) !!}
        {!! Form::text('exercise_video_link', null, ['class' => 'form-control bg-light', 'required']) !!}
    </div>

    <!-- Target Body Area -->
    <div class="col-md-6 mb-3">
        {!! Form::label('target_body_area', 'Target Body Area:', ['class' => 'form-label fw-bold']) !!}
        {!! Form::text('target_body_area', null, ['class' => 'form-control bg-light', 'required']) !!}
    </div>

    <!-- Buttons Centered -->
    <div class="col-12 d-flex justify-content-center mt-4">
        <a href="{{ route('standardexercises.index') }}" class="btn btn-cancel px-4 py-2 me-3">Cancel</a>
        {!! Form::submit('Save', ['class' => 'btn btn-save px-4 py-2']) !!}
    </div>
</div>

<style>
    /* Bold Labels */
    .form-label {
        font-weight: bold !important;
    }

    /* General Button Styling */
    .btn-cancel, .btn-save {
        font-weight: bold;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 15px;
        transition: 0.3s;
        text-align: center;
    }

    /* Save Button */
    .btn-save {
        background-color: #C96E04 !important; /* Orange */
        color: white !important;
    }

    .btn-save:hover {
        background-color: #A85C03 !important; /* Darker Orange */
    }

    /* Cancel Button (Two-Color Effect) */
    .btn-cancel {
        border: 2px solid #333;
        color: #333 !important;
        background-color: transparent;
    }

    .btn-cancel:hover {
        background-color: #333 !important;
        color: white !important;
    }

    /* Form Inputs */
    .form-control {
        background-color: #FFF7ED !important;
    }
</style>
