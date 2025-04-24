<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $technicianAssist->title }}</p>
</div>

<!-- Pdf Field -->
<div class="form-group">
    {!! Form::label('PDF', 'Pdf:') !!}
    <p>{{ $technicianAssist->PDF }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $technicianAssist->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $technicianAssist->updated_at }}</p>
</div>

