<table class="table table-responsive" id="practices-table">
    <thead>
        <th>Company Name</th>
        <th>Company Type</th>
        <th>Street</th>
        <th>City</th>
        <th>County</th>
        <th>Iban</th>
        <th>Bic</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($practices as $practice)
        <tr>
            <td>{!! $practice->company_name !!}</td>
            <td>{!! $practice->company_type !!}</td>
            <td>{!! $practice->street !!}</td>
            <td>{!! $practice->city !!}</td>
            <td>{!! $practice->county !!}</td>
            <td>{!! $practice->iban !!}</td>
            <td>{!! $practice->bic !!}</td>
            <td>
                {!! Form::open(['route' => ['practices.destroy', $practice->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('practices.show', [$practice->id]) !!}" class='btn btn-default btn-xs'><i class="far fa-eye"></i></i></a>
                    <a href="{!! route('practices.edit', [$practice->id]) !!}" class='btn btn-default btn-xs'><i class="far fa-edit"></i></i></a>
                    {!! Form::button('<i class="far fa-trash-alt"></i></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>