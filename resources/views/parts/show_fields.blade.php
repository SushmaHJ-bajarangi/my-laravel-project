<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $parts->title }}</p>
</div>



<div class="col-md-12">
    <h3>Part Details</h3>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Description</th>
            <th>price</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($persons) && count($persons) > 0)
        @php($count = 1)
        @foreach($persons as $person)
        <tr>
            <td>{{$count}}</td>
            <td>{{$person->description}}</td>
            <td>{{$person->price}}</td>
        </tr>
        @php($count++)
        @endforeach
        @else
        <tr>
            <td></td>
            <td>No Records Found</td>
            <td></td>
        </tr>
        @endif
        </tbody>
    </table>
</div>


<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $parts->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $parts->updated_at }}</p>
</div>