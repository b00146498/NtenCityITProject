<table class="table table-striped table-hover table-bordered shadow-lg">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Booking Date</th>
            <th>Start Time </th>
            
        
        </tr>
    </thead>
    <tbody>
        @foreach($appointments as $appointment)
            <tr>
                <td>{!! $appointment->id !!}</td>
                <td>{!! $appointment->booking_date !!}</td>
                <td>{!! $appointment->start_time !!}</td>
               
               

            </tr>
        @endforeach
    </tbody>
</table>


