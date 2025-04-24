<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $customers->name }}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>@if(isset($customers->email)) {{ $customers->email }} @else NO EMAIL @endif</p>
</div>



<!-- Contact Number Field -->
<div class="form-group">
    {!! Form::label('contact_number', 'Contact Number:') !!}
    <p>{{ $customers->contact_number }}</p>
</div>

<div class="form-group">
    {!! Form::label('address', 'Address:') !!}
    <p>{!! $customers->address !!}</p>
</div>

<div class="col-md-12">
    <h3>Authorized Persons</h3>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Contact Number</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($persons) && count($persons) > 0)
            @php($count = 1)
            @foreach($persons as $person)
                <tr>
                    <td>{{$count}}</td>
                    <td>{{$person->name}}</td>
                    <td>{{$person->contact_number}}</td>
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
    <p>{{ $customers->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $customers->updated_at }}</p>
</div>

