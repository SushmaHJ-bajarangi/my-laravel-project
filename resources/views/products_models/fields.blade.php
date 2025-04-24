<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control','id'=>'title']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::button('Save', ['class' => 'btn btn-primary','onclick' => 'product_model()']) !!}
    <a href="{{ route('productsModels.index') }}" class="btn btn-default">Cancel</a>
</div>


<script>
    function product_model(){
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
            $('#product_model').submit();

        }
    }

</script>