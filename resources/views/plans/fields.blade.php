<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('duration', 'Duration:') !!}
    <select class="form-control" name="duration" required>
        <option value="" selected disabled>Select Duration</option>
        <option @if(isset($plans) && $plans->duration == '3') selected @endif value="3">3 Months</option>
        <option @if(isset($plans) && $plans->duration == '6') selected @endif value="6">6 Months</option>
        <option @if(isset($plans) && $plans->duration == '12') selected @endif value="12">12 Months</option>
    </select>
</div>

<!-- description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('plans.index') }}" class="btn btn-default">Cancel</a>
</div>

@section('scripts')
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'description' );
    </script>
@endsection