<!-- Client Id Field -->
<div class="form-group">
    {!! Form::label('client_id', 'Client Id:') !!}
    <p>{!! $appointment->client_id !!}</p>
</div>

<!-- Employee Id Field -->
<div class="form-group">
    {!! Form::label('employee_id', 'Employee Id:') !!}
    <p>{!! $appointment->employee_id !!}</p>
</div>

<!-- Practice Id Field -->
<div class="form-group">
    {!! Form::label('practice_id', 'Practice Id:') !!}
    <p>{!! $appointment->practice_id !!}</p>
</div>

<!-- Booking Date Field -->
<div class="form-group">
    {!! Form::label('booking_date', 'Booking Date:') !!}
    <p>{!! $appointment->booking_date !!}</p>
</div>

<!-- Start Time Field -->
<div class="form-group">
    {!! Form::label('start_time', 'Start Time:') !!}
    <p>{!! $appointment->start_time !!}</p>
</div>

<!-- End Time Field -->
<div class="form-group">
    {!! Form::label('end_time', 'End Time:') !!}
    <p>{!! $appointment->end_time !!}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{!! $appointment->status !!}</p>
</div>

<!-- Notes Field -->
<div class="form-group">
    {!! Form::label('notes', 'Notes:') !!}
    <p>{!! $appointment->notes !!}</p>
</div>

