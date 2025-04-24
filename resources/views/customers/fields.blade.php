<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','id' => 'name']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control','id' => 'email']) !!}
</div>

<!-- Contact Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contact_number', 'Contact Number:') !!}
    {!! Form::text('contact_number', null, ['class' => 'form-control contact_number','id' => 'contact_number','maxlength'=>'10','pattern'=>'[0-9]{1}[0-9]{9}']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('address', 'Address:') !!}
    {!! Form::textarea('address', null, ['class' => 'form-control','id' => 'address']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('siteaddress', 'SiteAddress:') !!}
    {!! Form::textarea('siteaddress', null, ['class' => 'form-control','id' => 'siteaddress']) !!}
</div>

<div class="clearfix"></div>
{{--<div class="form-group col-sm-12">
    <h4><b>Authorized Persons</b></h4>
</div>
@if(isset($persons) && count($persons) > 0)
    @foreach($persons as $person)
        <div class="remove_{{$person->id}}">
            <div class="form-group col-sm-5">
                <label>Name</label>
                <input class="form-control" name="authorized_name[]name" type="text" value="{{$person->name}}" id="name">
            </div>
            <div class="form-group col-sm-5">
                <label>Contact Number</label>
                <input class="form-control contact_number" name="authorized_contact_number[]" type="text" value="{{$person->contact_number}}" maxlength="10">
            </div>
            <div class="form-group col-sm-2">
                <button type="button" style="margin-top: 23px" class="btn btn-danger" onclick="removeHelper('{{$person->id}}')">Remove</button>
            </div>
            <input class="form-control" name="authorized_id[]" type="hidden" value="{{$person->id}}">
        </div>
    @endforeach
@endif
<div id="dynamic_field"></div>
<div class="form-group col-sm-5">
    <label>Name</label>
    <input class="form-control" name="authorized_name[]" type="text" id="name">
</div>
<div class="form-group col-sm-5">
    <label>Contact Number</label>
    <input class="form-control contact_number" name="authorized_contact_number[]" type="text" maxlength="10">
</div>
<div class="form-group col-sm-2">
    <button type="button" style="margin-top: 23px" id="add" class="btn btn-info">Add Person</button>
</div>--}}

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::button('Save', ['class' => 'btn btn-primary','onclick' => 'customerSubmit()']) !!}
    <a href="{{ route('customers.index') }}" class="btn btn-default">Cancel</a>
</div>


@section('scripts')
    <script type="text/javascript">
        // check phone number n submit data
        function customerSubmit(){
            var customer_id = $('#customer_id').val();
            var name = $('#name').val();
            var email = $('#email').val();
            var contact_number = $('#contact_number').val();
            var address = $('#address').val();
            var siteaddress = $('#siteaddress').val();
            // var authorized_contact_number = $("input[name='authorized_contact_number']").val();
            var filter = /^\d*(?:\.\d{1,2})?$/;
            var value = "1234567.....";
            var NumberRegex = /^[0-9]*$/;
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            var value = [];
            $(".contact_number").each(function(e) {
                var number = $(this).val();
                value.push(number);
            });

            if(name == '' || name.length <= 0){
                toastr.clear();
                toastr.error('Name Required');
            }
            else if(email == '' || email.length <= 0){
                toastr.clear();
                toastr.error('Email Required');
            }
            else if(!regex.test(email)){
                toastr.clear();
                toastr.error('Enter Valid Email');
            }
            else if(contact_number == '' || contact_number.length <= 0){
                toastr.clear();
                toastr.error('Contact Number Required');
            }

            // else if(!NumberRegex.test(contact_number)){
            //     toastr.clear();
            //     toastr.error('Contact Number not valied Required');
            // }

            else if(address == '' || address.length <= 0){
                toastr.clear();
                toastr.error('Address Required');
            }

            else if(siteaddress == '' || siteaddress.length <= 0){
                toastr.clear();
                toastr.error('Site Address Required');
            }

            else{
                $.ajax({
                    url: '{{url('checkCustomerNumber')}}',
                    type: 'post',
                    data: {'contact_number':value,'customer_id':customer_id,'_token':'{{csrf_token()}}'},
                    success: function (response) {
                        if(response.response == 'number_exists')
                        {
                            $(".contact_number").each(function(e) {
                                var number = $(this).val();
                                if(!$.inArray(number,response.numbers)){
                                    $(this).css("border", "1px solid red");
                                }
                                else{
                                    $(this).css("border", "");
                                }
                            });
                            toastr.error('Customer Number Already Exists');
                            return false;
                        }
                        else {
                            $('#customer-form').submit();
                        }
                    }
                });
            }
        }



        /*// check phone number n submit data

        // {{--        dynamically add fields--}}
        $(document).ready(function(){
            var i = 1;
            $("#add").click(function(){
                i++;
                $('#dynamic_field').append('<div id="row'+i+'"><div class="form-group col-sm-5">\n' +
                    '    <label>Name</label>\n' +
                    '    <input class="form-control" name="authorized_name[]" type="text">\n' +
                    '</div>\n' +
                    '<div class="form-group col-sm-5">\n' +
                    '    <label>Contact Number</label>\n' +
                    '    <input class="form-control contact_number" name="authorized_contact_number[]" type="text" maxlength="10">\n' +
                    '</div>\n' +
                    '<div class="form-group col-sm-2">\n' +
                    '    <button type="button" id="'+i+'" style="margin-top: 23px" class="btn btn-danger btn_remove">Remove</button>\n' +
                    '</div></div>');
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id");
                $('#row'+button_id+'').remove();
            });
        });
        // {{--        dynamically add fields--}}*/

        // helper remove
        function removeHelper(id){
            $.ajax({
                url: '{{url('removePerson')}}',
                type: 'post',
                data: {'id':id,'_token':'{{csrf_token()}}'},
                beforeSend:function(){
                    return confirm("Are you sure?");
                },
                success: function (response) {
                    if(response == 'success'){
                        $('.remove_'+id).remove();
                        toastr.success('Person deleted successfully')
                    }
                }
            });

        }
        // helper remove





    </script>
@endsection
