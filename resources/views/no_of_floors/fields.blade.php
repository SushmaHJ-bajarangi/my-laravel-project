<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control','id'=>'title']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::button('Save', ['class' => 'btn btn-primary','onclick' => 'no_of_submit()']) !!}
    <a href="{{ route('noOfFloors.index') }}" class="btn btn-default">Cancel</a>
</div>



<script>
    function no_of_submit(){
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
            $('#no_of_floors').submit();

        }
    }

</script>