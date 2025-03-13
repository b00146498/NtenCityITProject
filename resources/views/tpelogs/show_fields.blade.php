<table class="table table-bordered table-sm">
    <tbody>
        <tr>
            <th style="width: 30%;">Training Plan</th>
            <td>{!! $tpelog->plan_id !!}</td>
        </tr>
        <tr>
            <th style="width: 30%;">Exercise</th>
            <td>{!! $tpelog->exercise->exercise_name ?? 'N/A' !!}</td>
        </tr>
        <tr>
            <th style="width: 30%;">Number of Sets</th>
            <td>{!! $tpelog->num_sets !!}</td>
        </tr>
        <tr>
            <th style="width: 30%;">Number of Reps</th>
            <td>{!! $tpelog->num_reps !!}</td>
        </tr>
        <tr>
            <th style="width: 30%;">Minutes</th>
            <td>{!! $tpelog->minutes !!}</td>
        </tr>
        <tr>
            <th style="width: 30%;">Intensity</th>
            <td>{!! $tpelog->intensity !!}</td>
        </tr>
        <tr>
            <th style="width: 30%;">Incline/Decline</th>
            <td>{!! $tpelog->incline !!}</td>
        </tr>
        <tr>
            <th style="width: 30%;">Times Per Week</th>
            <td>{!! $tpelog->times_per_week !!}</td>
        </tr>
    </tbody>
</table>