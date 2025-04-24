<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control','id'=>'title']) !!}
</div>

<div class="clearfix"></div>
<div class="form-group col-sm-12">
    <h4><b>Authorized Persons</b></h4>
</div>
@if(isset($persons) && count($persons) > 0)
@foreach($persons as $person)
<div class="remove_{{$person->id}}">
    <div class="form-group col-sm-4">
        <label>description</label>
        <input class="form-control" name="input_description[]" type="text" value="{{$person->description}}" id="name">
    </div>
    <div class="form-group col-sm-4">
        <label>Price</label>
        <input class="form-control price contact_number" name="input_price[]" type="text" value="{{$person->price}}" maxlength="6">
    </div>
    <div class="form-group col-sm-4">
        <label>GST</label>
        <input class="form-control contact_number gst" name="gst[]" type="text" maxlength="6" value="{{$person->gst}}" id="gstvalue" placeholder="Enter Gst Here">
    </div>
    <input class="form-control" name="authorized_id[]" type="hidden" value="{{$person->id}}">
</div>
@endforeach
@endif
<div class="form-group col-sm-12">
    <div class="form-table" id="customFields">
            <div class=" form-group">
                <a href="javascript:void(0);" class="addCF btn btn-info" style="margin-top:25px;"> + Add menu</a>
            </div>
            <div class="form-group col-sm-4">
                    <label>Description</label>
                <input class="form-control" name="input_description[]" type="text" id="customFieldName"  placeholder="Enter Description Here">
            </div>
            <div class="form-group col-sm-4">
                <label>Price</label>
                <input class="form-control contact_number price" name="input_price[]" type="text" maxlength="6" id="customFieldValue" placeholder="Enter Price Here">
            </div>
            <div class="form-group col-sm-4">
                <label>GST</label>
                <input class="form-control contact_number gst" name="gst[]" type="text" maxlength="6" id="gstvalue" placeholder="Enter Gst Here">
            </div>
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::button('Save', ['class' => 'btn btn-primary','onclick' => 'parts_submit()']) !!}
    <a href="{{ route('parts.index') }}" class="btn btn-default">Cancel</a>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    function parts_submit() {
        var title = $('#title').val();
        if (title == '' || title.length <= 0) {
            toastr.clear();
            toastr.error('Title Required');
        }  else {
            $('#parts-form').submit();


        }

    }
    $(document).ready(function(){
        $(".addCF").click(function(){
            $("#customFields").append(
                '<div class="row">' +
                '<div class=" form-group col-sm-3">'+
                '<label style="margin-left: 13px;">Description</label>\n' +
                '<input class="form-control name" name="input_description[]" type="text" id="customFieldName"  placeholder="Enter Description Here" style="margin-left:13px;">' +
                ' &nbsp;' +'</div>'+
                '<div class=" form-group col-sm-3">'+
                '<label>Price</label>\n' +
                ' <input type="text" class="form-control" id="customFieldValue" name="input_price[]" value="" placeholder="Enter Price Here" maxlength="6" />' +
                ' &nbsp;' +'</div>'+
                '<div class=" form-group col-sm-3">'+
                '<label>GST</label>\n' +
                ' <input type="text" class="form-control" id="gstvalue" name="gst[]" value="" placeholder="Enter Gst Here" maxlength="6" />' +
                ' &nbsp;' +'</div>'+
                '<div class="form-group col-sm-3">'+
                ' <a href="javascript:void(0);" style="margin-top: 23px;" class="remCF btn btn-danger">Remove X</a></div></div>');
        });
        $("#customFields").on('click','.remCF',function(){
            $(this).parent().parent().remove();
        });
    });
    $(".price").keypress(function (e) {
        // var maxLength = 6;
        // var textlen = maxLength - $(this).val().length;
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {

            $(this).addClass('invalid');
            toastr.clear();
            toastr.error('Enter numbers only');
            return false;
        }
        else{
            // $('#price').text(textlen);
            $(this).removeClass('invalid');
        }
    });



</script>

