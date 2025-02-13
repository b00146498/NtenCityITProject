<table class="table table-responsive" id="employees-table">
    <thead>
        <th>First Name</th>
        <th>Surname</th>
        <th>Contact Number</th>
        <th>Email</th>
        <th>Role</th>
        <th>Practice Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($employees as $employee)
        <tr>
            <td>{!! $employee->emp_first_name !!}</td>
            <td>{!! $employee->emp_surname !!}</td>
            <td>{!! $employee->contact_number !!}</td>
            <td>{!! $employee->email !!}</td>
            <td>{!! $employee->role !!}</td>
            <td>{!! $employee->practice_id !!}</td>
            <td>
                {!! Form::open(['route' => ['employees.destroy', $employee->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('employees.show', [$employee->id]) !!}" class='btn btn-default btn-xs'><i class="far fa-eye"></i></i></a>
                    <a href="{!! route('employees.edit', [$employee->id]) !!}" class='btn btn-default btn-xs'><i class="far fa-edit"></i></i></a>
                    {!! Form::button('<i class="far fa-trash-alt"></i></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>