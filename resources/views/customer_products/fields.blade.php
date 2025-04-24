@if(!isset($customerProducts))
    <div class="form-group col-sm-12">
        {!! Form::label('AMC', 'Just AMC Customer:') !!}
        <input  name="amc_value" type="checkbox" id="amc_value" >
    </div>
@else
    <div class="form-group col-sm-12">
        {!! Form::label('AMC', 'Just AMC Customer:') !!}
        <input  name="amc_value" type="checkbox" id="amc_value" {{$customerProducts->amc_value == 1 ? 'checked':''}} value="">
    </div>
@endif


<!-- Customer Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'Customer:') !!}
    @if(isset($customerProducts) && isset($customerProducts->customer_id))

    <select name="customer_id" class="form-control select2" id="customer_id" readonly="">
        <option selected disabled >Select Customer</option>
        @if(isset($customers) && count($customers) > 0)
            @foreach($customers as $customer)
            <option @if(isset($customerProducts) && $customerProducts->customer_id == $customer->id) selected @else  @endif  value="{{$customer->id}}">{{$customer->name}}</option>
            @endforeach
        @endif
    </select>

    @else
        <select name="customer_id" class="form-control select2" id="customer_id" >
            <option selected disabled>Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{$customer->id}}">{{$customer->name}}</option>
                @endforeach
        </select>
    @endif
</div>

<!--<div class="form-group col-sm-6">-->
<!--    {!! Form::label('area', 'Area:') !!}-->
<!--    {!! Form::text('area', null, ['class' => 'form-control','id' => 'area']) !!}-->
<!--</div>-->
<!---->
<!--<div class="form-group col-sm-6">-->
<!--    {!! Form::label('noofstops', 'No of Stops:') !!}-->
<!--    {!! Form::text('noofstops', null, ['class' => 'form-control','id' => 'noofstops']) !!}-->
<!--</div>-->

<div class="form-group col-sm-12 ">
    <label>CRM:</label>
    <select class="form-control select2" style="position: relative !important;"  name="crm_id" id="crm_id">
        <option selected disabled>Select Crm</option>
        @if(isset( $crm) && count( $crm) > 0)
        @foreach( $crm as $item)
        <option value="{{$item->id}}" {{ old('crm_id') == $item->id ? 'selected' : ''}}>{{$item->name}} </option>
        @endforeach
        @endif
    </select>
</div>

<div class="clearfix"></div>
@if(isset($customerProducts) && $customerProducts->model_id !='')
<div class="form-group col-sm-6">
    <label>Project Name</label>
    <input class="form-control" name="project_name"  id="project_name" required type="text" value="@if(isset($customerProducts)) {{$customerProducts->project_name}} @endif">
</div>
@else
<div class="form-group col-sm-6">
    <label>Project Name</label>
    <input class="form-control" name="project_name" id="project_name" required type="text" >
</div>
@endif
<!-- Model Id Field -->
<div class="form-group col-sm-6" id="model_data">
    {!! Form::label('model_id', 'Model:') !!}
    <select name="model_id" class="form-control select2" id="model_id">
        <option selected disabled>Select Model</option>
        @if(isset($models) && count($models) > 0)
            @foreach($models as $model)
                <option @if(isset($customerProducts) && $customerProducts->model_id == $model->id) selected @endif value="{{$model->id}}">{{$model->title}}</option>
            @endforeach
        @endif
    </select>
</div>
<div class="clearfix"></div>

<!-- Number Of Floors Field -->
<div class="form-group col-sm-6">
    {!! Form::label('number_of_floors', 'Number Of Floors:') !!}

    <select name="number_of_floors" class="form-control select2" id="number_of_floors">
        <option selected disabled>Select Number Of Floors</option>
        @if(isset($no_floors) && count($no_floors) > 0)
            @foreach($no_floors as $no_floor)
                <option @if(isset($customerProducts) && $customerProducts->number_of_floors == $no_floor->id) selected @endif value="{{$no_floor->id}}">{{$no_floor->title}}</option>
            @endforeach
        @endif
    </select>
</div>

<!-- Passenger Capacity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('passenger_capacity', 'Passenger Capacity:') !!}
   <select name="passenger_capacity" class="form-control select2" id="passenger_capacity">
       <option selected disabled>Select Passenger Capacity</option>
        @if(isset($passenger_capacity) && count($passenger_capacity) > 0)
            @foreach($passenger_capacity as $passenger_capa)
                <option @if(isset($customerProducts) && $customerProducts->passenger_capacity == $passenger_capa->id) selected @endif value="{{$passenger_capa->id}}">{{$passenger_capa->title}}</option>
            @endforeach
        @endif
    </select>
</div>

<!-- Distance Field -->
<div class="form-group col-sm-6">
    {!! Form::label('distance', 'Distance:') !!}
    <select class="form-control" name="distance" id="distance">
        <option selected disabled>Select Distance</option>
        <option @if(isset($customerProducts) && $customerProducts->distance == '100') selected @endif value="100">Less than 100</option>
        <option @if(isset($customerProducts) && $customerProducts->distance == '100-200') selected @endif value="100-200">Less than 100 Greater than 200</option>
        <option @if(isset($customerProducts) && $customerProducts->distance == '200') selected @endif value="200">Greater than 200</option>
    </select>
</div>

<!-- Unique Job Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unique_job_number', 'Unique Job Number:') !!}
    @if(isset($customerProducts) && isset($customerProducts->unique_job_number))
        <input type="text" value="{{$customerProducts->unique_job_number}}" class="form-control" id="unique_job_number" name="unique_job_number" readonly>
    @else
        <input type="text" class="form-control" id="unique_job_number" name="unique_job_number">
    @endif
</div>

<div class="form-group col-sm-6">
    <label>Plans</label>
    <select class="form-control" name="plan" id="plan">
        <option selected disabled hidden>Select Plans</option>
        @if(isset($plans) && count($plans) > 0)
            @foreach($plans as $plan)
                <option @if(isset($GenerateQuoteDetails) && isset($GenerateQuoteDetails->plan)) @if($GenerateQuoteDetails->plan == $plan->id) selected  @endif @endif   value="{{$plan->id}}">{{$plan->title}}</option>
            @endforeach
        @endif
    </select>
</div>

<!-- Warranty Start Date Field -->
<div class="form-group col-sm-6" id="warranty_start_date_id" @if(isset($customerProducts)) style="{{$customerProducts->amc_value == 1 ? 'display : none':''}}"@endif>
    {!! Form::label('warranty_start_date', 'Start Date:') !!}
    @if(isset($customerProducts) && isset($customerProducts->warranty_start_date))
        <div class = 'input-group date' id='datetimepicker4'>
            <input type = 'text' name="warranty_start_date" class="form-control" id="warranty_start_date" value="{{$customerProducts->warranty_start_date}}"  />
            <span class = "input-group-addon">
                <span class = "glyphicon glyphicon-time"></span>
            </span>
        </div>
    @else
        <div class = 'input-group date' id='datetimepicker4'>
            <input type = 'text'  id="warranty_start_date" name="warranty_start_date" class="form-control"  />
            <span class = "input-group-addon">
                <span class = "glyphicon glyphicon-time"></span>
            </span>
        </div>
    @endif
</div>

<!-- Warranty End Date Field -->
<div class="form-group col-sm-6" id="warranty_end_date_id" @if(isset($customerProducts)) style="{{$customerProducts->amc_value == 1 ? 'display : none':''}}"@endif>
    {!! Form::label('warranty_end_date', 'End Date:') !!}
    @if(isset($customerProducts) && isset($customerProducts->warranty_end_date))
        <div class = 'input-group date' id='datetimepicker3'>
            <input type = 'text' id="warranty_end_date"  name="warranty_end_date" class="form-control" value="{{$customerProducts->warranty_end_date}}"  />
            <span class = "input-group-addon">
                <span class = "glyphicon glyphicon-time"></span>
            </span>
        </div>
    @else
        <div class = 'input-group date' id='datetimepicker3'>
            <input type = 'text' id="warranty_end_date" name="warranty_end_date" class="form-control"  />
            <span class = "input-group-addon">
                <span class = "glyphicon glyphicon-time"></span>
            </span>
        </div>
    @endif
</div>


<div class="form-group col-sm-6" id="no_of_services_id" @if(isset($customerProducts)) style="{{$customerProducts->amc_value == 1 ? 'display : none':''}}"@endif>
    {!! Form::label('no_of_services', 'Number Of Services:') !!}
    @if(isset($customerProducts) && isset($customerProducts->no_of_services) && $customerProducts->no_of_services != 0)
        {!! Form::text('no_of_services', $customerProducts->no_of_services, ['class' => 'form-control price','id' => 'no_of_services', 'readonly','maxlength'=>'3']) !!}
    @else
        {!! Form::text('no_of_services', null, ['class' => 'form-control price','id' => 'no_of_services','maxlength'=>'3']) !!}
    @endif
</div>


<div class="form-group col-sm-6">
    {!! Form::label('side_status', 'Site Status:') !!}
    <select name="side_status" class="form-control select2" id="side_status">
        <option selected disabled>Select Product Status</option>
        @if(isset($product_status) && count($product_status) > 0)
            @foreach($product_status as $productstatus)
                <option @if(isset($customerProducts) && $customerProducts->site_status == $productstatus->id) selected @endif value="{{$productstatus->id}}">{{$productstatus->title}}</option>
            @endforeach
        @endif
    </select>
</div>


<div class="form-group col-sm-6">
    <label>Zone</label>
    <select class="form-control" name="zone" id="zone">
        <option selected disabled>Select Zone</option>
        @if(isset($customer_zones) && count($customer_zones) > 0)
            @foreach($customer_zones as $customer_zone)
                <option @if(isset($customerProducts) && $customerProducts->zone == $customer_zone->id) selected @endif  value="{{$customer_zone->id}}">{{$customer_zone->title}}</option>
            @endforeach
        @endif
    </select>
</div>


<div class="form-group col-sm-12">
    {!! Form::label('address', 'Address:') !!}
    {!! Form::text('address', null, ['class' => 'form-control','id' => 'address']) !!}
</div>


<div class="form-group col-sm-12">
    <h4><b>Authorized Persons</b></h4>
</div>
@if(isset($persons) && count($persons) > 0)
@foreach($persons as $person)
<div class="remove_{{$person->id}}">
    <div class="row">
        <div class="form-group col-sm-5">
            <label class="raised_persons">Name</label>
            <input class="form-control raised_persons" name="authorized_name[]" type="text" value="{{$person->name}}">
        </div>
        <div class="form-group col-sm-5">
            <label>Contact Number</label>
            <input class="form-control contact_number" name="authorized_contact_number[]" type="number" value="{{$person->contact_number}}">
        </div>
        {{--<div class="form-group col-sm-3">
            <label>Unique Job  Number</label>
            <input class="form-control unqiue_job_number" name="unqiue_job_number[]" type="number" value="{{$person->unique_job_number}}">
        </div>--}}
        <div class="form-group col-sm-2">
            <button type="button" style="margin-top: 23px" class="btn btn-danger" onclick="removeHelper('{{$person->id}}')">Remove</button>
        </div>
        <input class="form-control" name="authorized_id[]" type="hidden" value="{{$person->id}}">
    </div>
</div>
@endforeach
@endif

<div id="dynamic_field"></div>
<div class="row">
    <div class="form-group col-sm-5">
        <label class="raised_persons">Name</label>
        <input class="form-control raised_persons" name="authorized_name[]" type="text">
    </div>
    <div class="form-group col-sm-5">
        <label>Contact Number</label>
        <input class="form-control contact_number" name="authorized_contact_number[]" type="number">
    </div>
    <div class="form-group col-sm-2">
        <button type="button" style="margin-top: 23px" id="add" class="btn btn-info">Add Person</button>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::button('Save', ['class' => 'btn btn-primary','onclick' => 'customerProductSubmit()']) !!}
    <a href="{{ route('customerProducts.index') }}" class="btn btn-default">Cancel</a>
</div>

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <script>
        function initialize() {
            var input = document.getElementById('address');
            var autocomplete = new google.maps.places.Autocomplete(input);
        }

        google.maps.event.addDomListener(window, 'load', initialize);


        // customer add product function
        $("#amc_value").click(function(){
            var final_value=$('input[name="amc_value"]:checked').val();
            if(final_value)
            {
                var final_amc=$('#amc_value').val('yes');
                $('#warranty_start_date_id').hide();
                $('#warranty_end_date_id').hide();
                $('#no_of_services_id').hide();
//                    $('#model_data').hide();

            }
            else
            {
                var final_amc = $('#amc_value').val('no');
                $('#warranty_start_date_id').show();
                $('#warranty_end_date_id').show();
                $('#no_of_services_id').show();
                $('#model_data').show();

            }
        });

        function customerProductSubmit(){
            var customer_id = $('#customer_id').val();
            var model_id = $('#model_id').val();
            var number_of_floors = $('#number_of_floors').val();
            var passenger_capacity = $('#passenger_capacity').val();
            var distance = $('#distance').val();
            var warranty_start_date = $('#warranty_start_date').val();
            var warranty_end_date = $('#warranty_end_date').val();
            var no_of_services = $('#no_of_services').val();
            var customer_product_id = $('#customer_product_id').val();
            var unique_job_number = $('#unique_job_number').val();
            var address = $('#address').val();
            var zone = $('#zone').val();

            var value = [];
            $(".contact_number").each(function(e) {
                var number = $(this).val();
                value.push(number);
            });
            if(customer_id == null){
                toastr.clear();
                toastr.error('Customer Required');
            }
            else if(model_id == null){
                toastr.clear();
                toastr.error('Model Required');
            }
             else if(number_of_floors ==null){
                 toastr.clear();
                 toastr.error('Number Of Floors Required');
             }
             else if(passenger_capacity == null){
                 toastr.clear();
                 toastr.error('Passenger Capacity Required');
             }
            else if(distance == null){
                toastr.clear();
                toastr.error('Distance Required');
            }
            else if(warranty_end_date != '' && warranty_start_date == ''){
                toastr.clear();
                toastr.error('Warranty Start Date Required');
            }
            else if(warranty_start_date != '' && warranty_end_date == ''){
                toastr.clear();
                toastr.error('Warranty End Date Required');
            }
            else if(warranty_start_date != '' && warranty_end_date != '' && no_of_services == ''){
                toastr.clear();
                toastr.error('Number Of Services Required');
            }
            else if(no_of_services != '' && warranty_start_date == ''){
                toastr.clear();
                toastr.error('Warranty Start Date Required');
            }
            else if(no_of_services != '' && warranty_end_date == ''){
                toastr.clear();
                toastr.error('Warranty End Date Required');
            }
            else if(unique_job_number == '' || unique_job_number.length <= 0){
                toastr.clear();
                toastr.error('Job Number Required');
            }
            else if(address == '' || address.length <= 0){
                toastr.clear();
                toastr.error('Address Required');
            }
            else if(zone == null){
                toastr.clear();
                toastr.error('Zone Required');
            }
            else {
                $.ajax({
                    url: '{{url('checkCustomerJobNumber')}}',
                    type: 'post',
                    data: {'unique_job_number':$('#unique_job_number').val(),'customer_product_id':customer_product_id,'customer_number':value,'_token':'{{csrf_token()}}'},
                    success: function (response) {
                        console.log(response);
                        if(response == 'number_exists')
                        {
                            toastr.error('Customer Job Number Already Exists');
                            return false;
                        }
                        else if(response.response == 'customer_number_exists')
                        {
                            console.log(response.numbers);
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
                            var warranty_start_date = $('#warranty_start_date').val();
                            var warranty_end_date = $('#warranty_end_date').val();
                            if (!confirm("Are you sure start date "+' '+ warranty_start_date +' ' + "and end date" + ' '+ warranty_end_date)){
                                return false;
                            }
                            else {
                                $('#customer-product-form').submit();
                            }

                        }
                    }
                });
            }
        }

        var i = 1;
        $("#add").click(function(){
            i++;
            $('#dynamic_field').append('<div id="row'+i+'"><div class="form-group col-sm-5">\n' +
                '    <label>Name</label>\n' +
                '    <input class="form-control" name="authorized_name[]" type="text">\n' +
                '</div>\n' +
                '<div class="form-group col-sm-5">\n' +
                '    <label>Contact Number</label>\n' +
                '    <input class="form-control contact_number" name="authorized_contact_number[]" type="number">\n' +
                '</div>\n' +
                '<div class="form-group col-sm-2">\n' +
                '    <button type="button" id="'+i+'" style="margin-top: 23px" class="btn btn-danger btn_remove">Remove</button>\n' +
                '</div>' + '</div>');

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
        });

        // helper remove function
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

        // date picker and select2  function
        $(document).ready(function() {
                $("#datetimepicker3").datetimepicker({
                    format: "DD-MM-YYYY"
                });
                $("#datetimepicker4").datetimepicker({
                    format: "DD-MM-YYYY"
                });

                $(".select2").select2();
            });

        // price checking function
        $(".price").keypress(function (e) {
            var maxLength = 3;
            var textlen = maxLength - $(this).val().length;
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
@endsection
