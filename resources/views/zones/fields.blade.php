<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control','id'=>'title','required'=>'required']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('zones.index') }}" class="btn btn-default">Cancel</a>
</div>
<script>
    function zonesubmit(){
        var title = $('#title').val();

        if(title == '' && title.length <= 0){
            toastr.clear();
            toastr.error('Title Required');
        }
        else{

            $('#customer_note').submit();

        }
    }

</script>