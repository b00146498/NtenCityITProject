<table class="table table-responsive" id="customers-table">
    <thead>
        <th>Firstname</th>
        <th>Surname</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($customers as $customer)
        <tr>
            <td>{!! $customer->firstname !!}</td>
            <td>{!! $customer->surname !!}</td>
            <td>
                {!! Form::open(['route' => ['customers.destroy', $customer->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('customers.show', [$customer->id]) !!}" class='btn btn-default btn-xs'><i class="far fa-eye"></i></i></a>
                    <a href="{!! route('customers.edit', [$customer->id]) !!}" class='btn btn-default btn-xs'><i class="far fa-edit"></i></i></a>
                    {!! Form::button('<i class="far fa-trash-alt"></i></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>