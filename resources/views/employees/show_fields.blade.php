<table class="table table-bordered table-sm">
    <tbody>
        <tr>
            <th>First Name</th>
            <td>{!! $employee->emp_first_name !!}</td>
        </tr>
        <tr>
            <th>Surname</th>
            <td>{!! $employee->emp_surname !!}</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td>{!! \Carbon\Carbon::parse($employee->date_of_birth)->format('d/m/Y') !!}</td>
        </tr>
        <tr>
            <th>Gender</th>
            <td>{!! $employee->gender !!}</td>
        </tr>
        <tr>
            <th>Contact Number</th>
            <td>{!! $employee->contact_number !!}</td>
        </tr>
        <tr>
            <th>Emergency Contact</th>
            <td>{!! $employee->emergency_contact !!}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{!! $employee->email !!}</td>
        </tr>
        <tr>
            <th>Street</th>
            <td>{!! $employee->street !!}</td>
        </tr>
        <tr>
            <th>City</th>
            <td>{!! $employee->city !!}</td>
        </tr>
        <tr>
            <th>County</th>
            <td>{!! $employee->county !!}</td>
        </tr>
        <tr>
            <th>PPS Number</th>
            <td>{!! $employee->pps_number !!}</td>
        </tr>
        <tr>
            <th>Role</th>
            <td>{!! $employee->role !!}</td>
        </tr>
        <tr>
            <th>IBAN</th>
            <td>{!! $employee->iban !!}</td>
        </tr>
        <tr>
            <th>BIC</th>
            <td>{!! $employee->bic !!}</td>
        </tr>
        <tr>
            <th>Username</th>
            <td>{!! $employee->username !!}</td>
        </tr>
        @if ($employee->practice)
        <tr>
            <th>Practice</th>
            <td>{!! $employee->practice->company_name !!}</td>
        </tr>
        @endif
    </tbody>
</table>
