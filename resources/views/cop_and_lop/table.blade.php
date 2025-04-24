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
            <th>{{$item->name}}</th>
            <td class="text">
                <div class='btn-group'>
                    {!! Form::open(['url' => ['cop_and_lop/delete', $item->id], 'method' => 'post']) !!}
                    <a href="{{ url('cop_and_lop/show', [$item->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{{ url('cop_and_lop/edit', [$item->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    {!! Form::close() !!}
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>