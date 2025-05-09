<table class="table table-responsive" id="tpelogs-table">
    <thead>
        <th>Client Training Plan</th>
        <th>Exercise</th>
        <th>Number of Sets</th>
        <th>Number of Reps</th>
        <th>Minutes</th>
        <th>Intensity Level</th>
        <th>Incline</th>
        <th>Times Per Week</th>
        <th>Recovery Interval</th>
        <th>Completed</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($tpelogs as $tpelog)
        <tr>
            <td>{!! $tpelog->trainingPlan->client->first_name ?? 'N/A' !!} {!! $tpelog->trainingPlan->client->surname ?? '' !!}</td>
            <td>{{ $tpelog->exercise->exercise_name ?? 'N/A' }}</td>
            <td>{!! $tpelog->num_sets !!}</td>
            <td>{!! $tpelog->num_reps !!}</td>
            <td>{!! $tpelog->minutes !!}</td>
            <td>{!! $tpelog->intensity !!}</td>
            <td>
                @if ($tpelog->incline > 0)
                    Incline {{ $tpelog->incline }}%
                @elseif ($tpelog->incline < 0)
                    Decline {{ abs($tpelog->incline) }}%
                @else
                    Flat (0%)
                @endif
            </td>
            <td>{!! $tpelog->times_per_week !!}</td>
            <td>
                @php
                    $recoverySeconds = $tpelog->recovery_interval ?? 0;
                    $mins = floor($recoverySeconds / 60);
                    $secs = $recoverySeconds % 60;
                @endphp
                {{ $mins }}m {{ str_pad($secs, 2, '0', STR_PAD_LEFT) }}s
            </td>
            <td>
                @if ($tpelog->completed)
                    <span class="text-success">✅ Completed</span>
                @else
                    <span class="text-danger">❌ Not Completed</span>
                @endif
            </td>
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