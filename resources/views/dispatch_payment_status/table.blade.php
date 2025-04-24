<div class="table-responsive">
    <table class="table" id="example">
        <thead>
        <tr>
            <th>Name</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>

        @foreach($data as $item)
        <tr>
<!--            <td>  --><?php //echo $item;?><!--</td>-->
            <td>{{ $item->Name}}</td>
            <td class="text-center">
                <div class='btn-group'>
                    {!! Form::open(['url' => ['dispatch_payment_status/delete', $item->id], 'method' => 'post']) !!}
                    <a href="{{ url('dispatch_payment_status/show', [$item->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{{ url('dispatch_payment_status/edit', [$item->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    {!! Form::close() !!}
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

