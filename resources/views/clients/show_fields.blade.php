<table class="table table-bordered table-sm">
    <tbody>
        <tr>
            <th style="width: 30%;">First Name</th>
            <td>{!! $client->first_name !!}</td>
        </tr>
        <tr>
            <th style="width: 30%;">Surname</th>
            <td>{!! $client->surname !!}</td>
        </tr>
        <tr>
            <th style="width: 30%;">Date of Birth</th>
            <td>{!! \Carbon\Carbon::parse($client->date_of_birth)->format('d/m/Y') !!}</td>
        </tr>
        <tr>
            <th style="width: 30%;">Gender</th>
            <td>{!! $client->gender !!}</td>
        </tr>
        <tr>
            <th style="width: 30%;">Email</th>
            <td>{!! $client->email !!}</td>
        </tr>
        <tr>
            <th style="width: 30%;">Contact Number</th>
            <td>{!! $client->contact_number !!}</td>
        </tr>
        <tr>
            <th style="width: 30%;">Street</th>
            <td>{!! $client->street !!}</td>
        </tr>
        <tr>
            <th style="width: 30%;">City</th>
            <td>{!! $client->city !!}</td>
        </tr>
        <tr>
            <th style="width: 30%;">County</th>
            <td>{!! $client->county !!}</td>
        </tr>
        <tr>
            <th style="width: 30%;">Username</th>
            <td>{!! $client->username !!}</td>
        </tr>
        <tr>
            <th style="width: 30%;">Account Status</th>
            <td>
                <span class="badge bg-{!! $client->account_status == 'Active' ? 'success' : 'danger' !!}">
                    {!! $client->account_status !!}
                </span>
            </td>
        </tr>
        @if ($client->practice)
        <tr>
            <th style="width: 30%;">Practice</th>
            <td class="small-text">{!! $client->practice->company_name !!}</td>
        </tr>
        @endif
    </tbody>
</table>