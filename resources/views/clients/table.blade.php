<table class="table table-striped table-hover table-bordered shadow-lg">
    <thead class="table-light">
        <tr>
            <th>First Name</th>
            <th>Surname</th>
            <th>Contact Number</th>
            <th>Email</th>
            <th>Account Status</th>
            <th>Practice</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clients as $client)
            <tr>
                <td>{!! $client->first_name !!}</td>
                <td>{!! $client->surname !!}</td>
                <td>{!! $client->contact_number !!}</td>
                <td>{!! $client->email !!}</td>
                <td>
                    <span class="badge bg-{!! $client->account_status == 'Active' ? 'success' : 'danger' !!}">
                        {!! $client->account_status !!}
                    </span>
                </td>
                <td>{!! $client->practice->company_name ?? 'N/A' !!}</td>
                <td>
                    {!! Form::open(['route' => ['clients.destroy', $client->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('clients.show', [$client->id]) !!}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{!! route('clients.edit', [$client->id]) !!}" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', [
                            'type' => 'submit',
                            'class' => 'btn btn-danger btn-xs',
                            'onclick' => "return confirm('Are you sure?')"
                        ]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
