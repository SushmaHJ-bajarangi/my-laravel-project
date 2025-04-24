<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $team->title }}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $team->name }}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $team->email }}</p>
</div>

<!-- Contact Number Field -->
<div class="form-group">
    {!! Form::label('contact_number', 'Contact Number:') !!}
    <p>{{ $team->contact_number }}</p>
</div>

<div class="form-group">
    {!! Form::label('zone', 'Zone:') !!}
    <p>{{ $team->zone }}</p>
</div>

<div class="col-md-12">
    <h3>Helpers</h3>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Contact Number</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($helpers) && count($helpers) > 0)
                @php($count = 1)
                @foreach($helpers as $helper)
                    <tr>
                        <td>{{$count}}</td>
                        <td>{{$helper->name}}</td>
                        <td>{{$helper->contact_number}}</td>
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
    <p>{{ $team->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $team->updated_at }}</p>
</div>

