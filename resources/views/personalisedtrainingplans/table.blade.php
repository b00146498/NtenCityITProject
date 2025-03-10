<table class="table table-responsive" id="personalisedtrainingplans-table">
    <thead>
        <th>Client</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($personalisedtrainingplans as $personalisedtrainingplan)
        <tr>
            <td>{{ $personalisedtrainingplan->client->first_name ?? 'N/A' }} {{ $personalisedtrainingplan->client->surname ?? '' }}</td>
            <td>{!! $personalisedtrainingplan->start_date !!}</td>
            <td>{!! $personalisedtrainingplan->end_date !!}</td>
            <td>
                {!! Form::open(['route' => ['personalisedtrainingplans.destroy', $personalisedtrainingplan->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('personalisedtrainingplans.show', [$personalisedtrainingplan->id]) !!}" class='btn btn-default btn-xs'><i class="far fa-eye"></i></i></a>
                    <a href="{!! route('personalisedtrainingplans.edit', [$personalisedtrainingplan->id]) !!}" class='btn btn-default btn-xs'><i class="far fa-edit"></i></i></a>
                    {!! Form::button('<i class="far fa-trash-alt"></i></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>