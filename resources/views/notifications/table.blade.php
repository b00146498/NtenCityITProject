<table class="table table-responsive" id="notifications-table">
    <thead>
        <th>Type</th>
        <th>Notifiable Type</th>
        <th>Notifiable Id</th>
        <th>Data</th>
        <th>Read At</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($notifications as $notification)
        <tr>
            <td>{!! $notification->type !!}</td>
            <td>{!! $notification->notifiable_type !!}</td>
            <td>{!! $notification->notifiable_id !!}</td>
            <td>{!! $notification->data !!}</td>
            <td>{!! $notification->read_at !!}</td>
            <td>
                {!! Form::open(['route' => ['notifications.destroy', $notification->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('notifications.show', [$notification->id]) !!}" class='btn btn-default btn-xs'><i class="far fa-eye"></i></i></a>
                    <a href="{!! route('notifications.edit', [$notification->id]) !!}" class='btn btn-default btn-xs'><i class="far fa-edit"></i></i></a>
                    {!! Form::button('<i class="far fa-trash-alt"></i></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>