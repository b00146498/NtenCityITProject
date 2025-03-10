<table class="table table-responsive" id="standardexercises-table">
    <thead>
        <th>Exercise Name</th>
        <th>Exercise Video Link</th>
        <th>Target Body Area</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($standardexercises as $standardexercises)
        <tr>
            <td>{!! $standardexercises->exercise_name !!}</td>
            <td>{!! $standardexercises->exercise_video_link !!}</td>
            <td>{!! $standardexercises->target_body_area !!}</td>
            <td>
                {!! Form::open(['route' => ['standardexercises.destroy', $standardexercises->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('standardexercises.show', [$standardexercises->id]) !!}" class='btn btn-default btn-xs'><i class="far fa-eye"></i></i></a>
                    <a href="{!! route('standardexercises.edit', [$standardexercises->id]) !!}" class='btn btn-default btn-xs'><i class="far fa-edit"></i></i></a>
                    {!! Form::button('<i class="far fa-trash-alt"></i></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>