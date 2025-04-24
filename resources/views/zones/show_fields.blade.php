<!-- Description Field -->
<div class="form-group">
    {!! Form::label('title', 'title:') !!}
    <p>{{ $zone->title }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $zone->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $zone->updated_at }}</p>
</div>

