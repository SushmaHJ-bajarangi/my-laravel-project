@if (auth()->check())
@if (auth()->user()->role == 1)

{!! Form::open(['route' => ['forwardReasons.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('forwardReasons.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
    <a href="{{ route('forwardReasons.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>
    </a>
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
@else
<th></th>
@endif
@endif