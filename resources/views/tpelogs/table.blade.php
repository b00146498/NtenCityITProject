<table class="table table-responsive" id="tpelogs-table">
    <thead>
        <th>Plan Id</th>
        <th>Exercise Id</th>
        <th>Num Sets</th>
        <th>Num Reps</th>
        <th>Minutes</th>
        <th>Intensity</th>
        <th>Incline</th>
        <th>Times Per Week</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($tpelogs as $tpelog)
        <tr>
            <td>{!! $tpelog->plan_id !!}</td>
            <td>{!! $tpelog->exercise_id !!}</td>
            <td>{!! $tpelog->num_sets !!}</td>
            <td>{!! $tpelog->num_reps !!}</td>
            <td>{!! $tpelog->minutes !!}</td>
            <td>{!! $tpelog->intensity !!}</td>
            <td>{!! $tpelog->incline !!}</td>
            <td>{!! $tpelog->times_per_week !!}</td>
            <td>
                {!! Form::open(['route' => ['tpelogs.destroy', $tpelog->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('tpelogs.show', [$tpelog->id]) !!}" class='btn btn-default btn-xs'><i class="far fa-eye"></i></i></a>
                    <a href="{!! route('tpelogs.edit', [$tpelog->id]) !!}" class='btn btn-default btn-xs'><i class="far fa-edit"></i></i></a>
                    {!! Form::button('<i class="far fa-trash-alt"></i></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>