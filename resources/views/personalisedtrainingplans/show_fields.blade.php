<table class="table table-bordered table-sm">
    <tbody>
        <tr>
            <th style="width: 30%;">Client</th>
            <td>{{ $personalisedtrainingplan->client->first_name ?? 'N/A' }} {{ $personalisedtrainingplan->client->surname ?? '' }}</td>
        </tr>
        <tr>
            <th style="width: 30%;">Start Date</th>
            <td>{{ \Carbon\Carbon::parse($personalisedtrainingplan->start_date)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th style="width: 30%;">End Date</th>
            <td>{{ \Carbon\Carbon::parse($personalisedtrainingplan->end_date)->format('d/m/Y') }}</td>
        </tr>
    </tbody>
</table>


