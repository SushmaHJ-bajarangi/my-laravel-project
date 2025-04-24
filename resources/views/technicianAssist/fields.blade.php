<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Pdf Field -->
<div class="form-group col-sm-6">
    {!! Form::label('PDF', 'Pdf:') !!}
    {!! Form::file('PDF', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('technicianAssists.index') }}" class="btn btn-default">Cancel</a>
</div>
