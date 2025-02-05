<table class="table table-responsive" id="employees-table">
    <thead>
        <th>Emp First Name</th>
        <th>Emp Surname</th>
        <th>Date Of Birth</th>
        <th>Gender</th>
        <th>Contact Number</th>
        <th>Emergency Contact</th>
        <th>Email</th>
        <th>Street</th>
        <th>City</th>
        <th>County</th>
        <th>Pps Number</th>
        <th>Role</th>
        <th>Iban</th>
        <th>Bic</th>
        <th>Username</th>
        <th>Password</th>
        <th>Practice Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($employees as $employee)
        <tr>
            <td>{!! $employee->emp_first_name !!}</td>
            <td>{!! $employee->emp_surname !!}</td>
            <td>{!! $employee->date_of_birth !!}</td>
            <td>{!! $employee->gender !!}</td>
            <td>{!! $employee->contact_number !!}</td>
            <td>{!! $employee->emergency_contact !!}</td>
            <td>{!! $employee->email !!}</td>
            <td>{!! $employee->street !!}</td>
            <td>{!! $employee->city !!}</td>
            <td>{!! $employee->county !!}</td>
            <td>{!! $employee->pps_number !!}</td>
            <td>{!! $employee->role !!}</td>
            <td>{!! $employee->iban !!}</td>
            <td>{!! $employee->bic !!}</td>
            <td>{!! $employee->username !!}</td>
            <td>{!! $employee->password !!}</td>
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