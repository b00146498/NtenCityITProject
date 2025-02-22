<table class="table table-responsive" id="appointments-table">
    <thead>
        <th>Client Id</th>
        <th>Employee Id</th>
        <th>Practice Id</th>
        <th>Booking Date</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Status</th>
        <th>Notes</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($appointments as $appointment)
        <tr>
            <td>{!! $appointment->client_id !!}</td>
            <td>{!! $appointment->employee_id !!}</td>
            <td>{!! $appointment->practice_id !!}</td>
            <td>{!! $appointment->booking_date !!}</td>
            <td>{!! $appointment->start_time !!}</td>
            <td>{!! $appointment->end_time !!}</td>
            <td>{!! $appointment->status !!}</td>
            <td>{!! $appointment->notes !!}</td>
            <td>
                {!! Form::open(['route' => ['appointments.destroy', $appointment->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('appointments.show', [$appointment->id]) !!}" class='btn btn-default btn-xs'><i class="far fa-eye"></i></i></a>
                    <a href="{!! route('appointments.edit', [$appointment->id]) !!}" class='btn btn-default btn-xs'><i class="far fa-edit"></i></i></a>
                    {!! Form::button('<i class="far fa-trash-alt"></i></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>