@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Add new Training Plan Exercises/Workout Logs/Exercise Assignments
        </h1>
    </section>
    <div class="content">
        @include('basic-template::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'tpelogs.store']) !!}

                        @include('tpelogs.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
h1, h2, h3, h4, h5, h6 {
    font-weight: bold !important;
    font-size: 2rem !important; /* Adjust size */
}
</style>

<script>
    function changeValue(inputId, change) {
        let input = document.getElementById(inputId);
        let currentValue = parseInt(input.value) || 0;
        let newValue = currentValue + change;

        // Ensure the value doesn't go below 1
        if (newValue < 1) newValue = 1;

        input.value = newValue;
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let inclineValueInput = document.getElementById("incline_value");
        let inclineRadio = document.getElementById("incline_option");
        let declineRadio = document.getElementById("decline_option");
        let finalInclineInput = document.getElementById("final_incline");

        function updateInclineValue() {
            let inclineValue = parseFloat(inclineValueInput.value) || 0;
            if (declineRadio.checked) {
                finalInclineInput.value = -inclineValue; // Store as negative for decline
            } else {
                finalInclineInput.value = inclineValue; // Store as positive for incline
            }
        }

        // Event listeners to update the hidden field
        inclineRadio.addEventListener("change", updateInclineValue);
        declineRadio.addEventListener("change", updateInclineValue);
        inclineValueInput.addEventListener("input", updateInclineValue);

        // Increment/Decrement buttons
        window.changeValue = function (change) {
            let currentValue = parseInt(inclineValueInput.value) || 0;
            let newValue = currentValue + change;
            
            // Limit range (0% to 20%)
            if (newValue < 0) newValue = 0;
            if (newValue > 20) newValue = 20;
            
            inclineValueInput.value = newValue;
            updateInclineValue();
        };
    });
</script>

