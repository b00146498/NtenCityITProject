<table class="table table-responsive" id="clients-table">
    <thead>
        <th>First Name</th>
        <th>Surname</th>
        <th>Email</th>
        <th>Contact Number</th>
        <th>Account Status</th>
        <th>Practice Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($clients as $client)
        <tr>
            <td>{!! $client->first_name !!}</td>
            <td>{!! $client->surname !!}</td>
            <td>{!! $client->email !!}</td>
            <td>{!! $client->contact_number !!}</td>
            <td>{!! $client->account_status !!}</td>
            <td>{!! $client->practice_id !!}</td>
            <td>
                {!! Form::open(['route' => ['clients.destroy', $client->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('clients.show', [$client->id]) !!}" class='btn btn-default btn-xs'><i class="far fa-eye"></i></i></a>
                    <a href="{!! route('clients.edit', [$client->id]) !!}" class='btn btn-default btn-xs'><i class="far fa-edit"></i></i></a>
                    {!! Form::button('<i class="far fa-trash-alt"></i></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>