<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::button('Save', ['class' => 'btn btn-primary','onclick' => 'passengersubmit()']) !!}
    <a href="{{ route('passengerCapacities.index') }}" class="btn btn-default">Cancel</a>
</div>


<script>
    function passengersubmit(){
        var title = $('#title').val();

        if(title == '' && title.length <= 0){
            toastr.clear();
            toastr.error('Title Required');
        }
            // if(title == null){
            //     toastr.clear();
            //     toastr.error('Title Required');
        // }
        else{
            $('#passenger').submit();

        }
    }

</script>