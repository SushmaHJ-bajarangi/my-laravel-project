<div class="table-responsive">
    <table class="table" id="example">
        <thead>
        <tr>
            <th>Title</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>

        @foreach($data as $item)
            <tr>
                <th>{{$item->title}}</th>
                <td class="text-center">
                    <div class='btn-group'>
                        {!! Form::open(['url' => ['car_bracket_readiness_status/delete', $item->id], 'method' => 'post']) !!}
                        <a href="{{ url('car_bracket_readiness_status/show', [$item->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ url('car_bracket_readiness_status/edit', [$item->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        {!! Form::close() !!}
                    </div>
                </td>
            </tr>

        @endforeach

        </tbody>
    </table>
</div>