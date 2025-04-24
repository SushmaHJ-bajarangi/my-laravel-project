@extends('layouts.app')

@section('content')

<section class="content-header">
    <h1>
        CRM Production Request
    </h1>
</section>

<div class="content">
    @include('adminlte-templates::common.errors')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <form method="post" action="{{url('crm_production/store')}}">
                    @csrf

                    <hr style="clear: both;">
                    <div class="form-group col-sm-12">
                        <label for=""> For Office Use only</label>
                    </div>
                    <hr style="clear: both;">

                    <div class="form-group col-sm-12">
                        <label>CRM:</label>
                        <select class="form-control select2" style="position: relative !important;"  name="crm_id" id="crm_id">
                            <option selected disabled>Select Crm</option>
                            @if(isset( $crm) && count( $crm) > 0)
                            @foreach( $crm as $item)
                                    <option value="{{$item->id}}" {{ old('crm_id') == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                            @endforeach
                            @endif
                        </select>
                     </div>

                    <div class="form-group col-sm-12">
                        <label for="payment_received_for_manufactruing_date">Payment Received for Manufacturing Date :</label>
                        <input class="form-control" id="payment_received_manufacturing_date" name="payment_received_manufacturing_date" type="date" value="{{old('payment_received_manufacturing_date')}}">
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="crm_confirmation_date">Crm Confirmation Date:</label>
                        <input class="form-control" id="crm_confirmation_date" name="crm_confirmation_date" type="date" value="{{old('crm_confirmation_date')}}">
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="job_no">Job No:</label>
                        {{--           <input class="form-control" id="job_no" required="true"  name="job_no" type="number">--}}
                        <input class ="form-control" id="job_no"  name="job_no" min="1" type="number" value="{{old('job_no')}}">
                    </div>

                    <div class="form-group col-sm-12">
                        <label>Customer Name</label>
                        <input class ="form-control" id="customer_id"  name="customer_id"  type="text" value="{{old('customer_id')}}">
{{--                        <button type="button" style="margin-bottom: 10px" class="btn btn-primary" data-toggle="modal" data-target="#customer_modal">--}}
{{--                            +--}}
{{--                        </button>--}}

{{--                        <select class="form-control select2"  style="position: relative !important;" name="customer_id" id="customer_id" required="" value="{{old('customer_id')}}">--}}
{{--                            <option selected disabled>Select Customer</option>--}}
{{--                            @if(isset($customer) && count($customer) > 0)--}}
{{--                            @foreach($customer as $item)--}}
{{--                            <option value="{{$item->name}}" {{ old('customer_id') == $item->name ? 'selected' : ''}}>{{$item->name}}</option>--}}
{{--                            @endforeach--}}
{{--                            @endif--}}
{{--                        </select>--}}
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="addressu">Address Details:</label>
                        <textarea class="form-control" id="addressu" name="addressu" cols="50" rows="10" value ="{{old('addressu')}}"></textarea>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="contract_value">Contract Value:</label>
                        <input class="form-control" id="contract_value" name="contract_value" type="text" value="{{old('contract_value')}}">
                    </div>

                    <div class="form-group col-sm-12">
                        <label>Request for Production</label>
                        <select class="form-control select2"  style="position: relative !important;"  name="stage_of_materials_id" id="stage_of_materials_id" value="{{old('stage_of_materials_id')}}">
                            <option selected disabled>Select Request for Production</option>
                            @if(isset($stage_of_material) && count($stage_of_material) > 0)
                            @foreach($stage_of_material as $item)
                            <option value="{{$item->id}}" {{ old('stage_of_materials_id') == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-sm-12">
                        <label>Standard / Non standard</label>
                        <select class="form-control select2" name="priority_id" id="priority_id" value="{{old('priority_id')}}">
                            <option selected disabled>Select Standard / Non standard</option>
                            @if(isset( $priority) && count( $priority) > 0)
                            @foreach( $priority as $item)
                            <option value="{{$item->id}}" {{ old('priority_id') == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="requested_date_for_start_of_manufacturing_from_teknix_office">Requested Date for Start of Manufacturing from Teknix Office:</label>
                        <input class="form-control" id="requested_date_for_start_of_manufacturing_from_teknix_office" name="requested_date_for_start_of_manufacturing_from_teknix_office" type="date" value="{{old('requested_date_for_start_of_manufacturing_from_teknix_office')}}">
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="dispatch_request_date_from_teknix_office">Dispatch Request Date from Teknix Office:</label>
                        <input class="form-control" id="dispatch_request_date_from_teknix_office" name="dispatch_request_date_from_teknix_office" type="date"  value="{{old('dispatch_request_date_from_teknix_office')}}">
                    </div>

                    <div class="form-group col-sm-12">
                        <label>Dispatch Payment Status</label>
                        <select class="form-control select2" style="position: relative !important;" name="dispatch_payments_status_id" id="dispatch_payments_status_id">
                            <option selected disabled>Dispatch Payment Status</option>
                            @if(isset($dispatch_payments_status) && count($dispatch_payments_status) > 0)
                                @foreach($dispatch_payments_status as $item)
                                    <option value="{{$item->id}}" {{ old('dispatch_payments_status_id') == $item->id ? 'selected' : ''}}>{{$item->Name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for=" amount_pending_for_dispatch_in_INR">  Amount Pending for Dispatch in INR:</label>
                        <input class="form-control" id="amount_pending_for_dispatch" name="amount_pending_for_dispatch" type="number" min="0" value="{{old('amount_pending_for_dispatch')}}">
                    </div>

                    <div class="form-group col-sm-12">
                        <label for=" amount_pending_for_dispatch_in_INR"> Comments:</label>
                        <input class="form-control" id="dispatch_comment" name="dispatch_comment" type="text"  value="{{old('dispatch_comment')}}">
                    </div>

                    <hr style="clear: both;">
                    <div class="form-group col-sm-12">
                        <label for=""> For Factory use only</label>
                    </div>
                    <hr style="clear: both;">

                    <div class="form-group col-sm-12">
                        <label for="specifications">Specifications:</label>
                        <textarea class="form-control" id="specifications" name="specifications" cols="50" rows="10" value="{{old('specifications')}}"></textarea>
                    </div>

                    <div class="form-group col-sm-12">
                        <label>Manufacturing Status</label>
                        <select class="form-control select2"  style="position: relative !important;" name="manufacture_status_id" id="manufacture_status_id">
                            <option selected disabled>Select Manufacturing Status</option>
                            @if(isset($manufacture_status) && count($manufacture_status) > 0)
                                @foreach($manufacture_status as $item)
                                    <option value="{{$item->id}}" {{ old('manufacture_status_id') == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-sm-12">
                        <label>Manufacturing -Stage / Lot </label>
                        <select class="form-control select2"  style="position: relative !important;" name="manufacture_stages_id" id="manufacture_stages_id">
                            <option selected disabled>Select Manufacturing -Stage / Lot</option>
                            @if(isset($manufacture_stages) && count($manufacture_stages) > 0)
                                @foreach($manufacture_stages as $item)
                                    <option value="{{$item->id}}" {{ old('manufacture_stages_id') == $item->id ? 'selected' : ''}} >{{$item->title}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="manufacture_completion_date">Manufacture Completion Date:</label>
                        <input class="form-control" id="manufacture_completion_date" name="manufacture_completion_date" type="date" value="{{old('manufacture_completion_date')}}">
                    </div>

                    <div class="form-group col-sm-12 ckeck1">
                        <label for="myCheck">Is Revised:</label>
                        <input type="checkbox" id="myCheck" onclick="myFunction()" name="is_revised">
                    </div>

                    <div class="form-group factory-revised col-sm-12" style="display:none">
                        <label for="factory_commitment_date">Factory Commitment Date:</label>
                        <input  id="factory_commitment_date" class="form-control" name="factory_commitment_date" type="date" value="{{old('factory_commitment_date')}}">
                    </div>

                    <div class="form-group col-sm-12">
                        <label for=" manufacture_comment"> Manufacture Comment:</label>
                        <input class="form-control" id="manufacture_comment" name="manufacture_comment" type="text" value="{{old('manufacture_comment')}}">
                    </div>

                    <hr style="clear: both;">
                    <div class="form-group col-sm-12">
                        <label for=""> For Godown Use only</label>
                    </div>
                    <hr style="clear: both;">

                    <div class="form-group col-sm-12">
                        <label for="material_received_date_from_factory">Material Received Date From Factory:</label>
                        <input class="form-control" id="material_received_date_from_factory" name="material_received_date_from_factory" type="date"  value="{{old('material_received_date_from_factory')}}">
                    </div>


                    <div class="form-group col-sm-12">
                        <label for="no_of_days_since_ready_for_dispatch">No of days since ready for dispatch:</label>
                        <input class="form-control" id="no_of_days_since_ready_for_dispatch" value="" name="no_of_days_since_ready_for_dispatch" type="number" readonly>
                    </div>

                        <!----Dynamic feild----->
                        <div class="form-group col-sm-12">
                        <hr style="clear: both;">
                        <label for="manufacturing_stage_lot">Dispatch</label>
                        <div class="row man_stage_append">
                            <div class="man_stages_list">

                                <div class="form-group col-sm-3">
                                    <label>Dispatch - Stage / Lot</label>
                                    <select class="form-control select2"  style="position: relative !important;" name="dispatch_stage_lots_status_id[]" id="dispatch_stage_lots_status_id" >
                                        <option selected disabled>Select Dispatch - Stage / Lot</option>
                                        @if(isset($dispatch_stage_lots_status) && count($dispatch_stage_lots_status) > 0)
                                            @foreach($dispatch_stage_lots_status as $item)
                                                <option value="{{$item->id}}"  {{ old('dispatch_stage_lots_status_id[]') == $item->id ? 'selected' : ''}}>{{$item->Name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="plandispatch_date"> Plan dispatch date:</label>
                                    <input class="form-control" id="plandispatch_date" name="plandispatch_date[]" type="date" value="{{old('plandispatch_date[]')}}">
                                </div>

                                <div class="form-group col-sm-3">
                                    <label>Dispatch Status </label>
                                    <select class="form-control select2"  style="position: relative !important;" name="dispatch_status_id[]" id="dispatch_status_id" >
                                        <option selected disabled>Select Dispatch Status</option>
                                        @if(isset($dispatch_status) && count($dispatch_status) > 0)
                                            @foreach($dispatch_status as $item)
                                                <option value="{{$item->id}}" {{ old('dispatch_stage_lots_status_id[]') == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label for=" go_down_dispatch_completion_date"> Go Down: Dispatch Completion  Date:</label>
                                    <input class="form-control" id="go_down_dispatch_completion_date" name="go_down_dispatch_completion_date[]" type="date" value="{{old('go_down_dispatch_completion_date[]')}}">
                                </div>
                                
                                <div class="form-group col-sm-1 mt-4">
                                    <button type="button" onclick="addManStageLot()"><i class="glyphicon glyphicon-plus"></i></button>
                                </div>

                            </div>
                        </div>
                        <hr style="clear: both;">
                    </div>
                        <!----End of Dynamic feild----->

                    <div class="form-group col-sm-12">
                        <label for=" comments"> Comments:</label>
                        <input class="form-control" id="comments" name="comments" type="text">
                    </div>

                    <!-- Submit Field -->
                    <div class="form-group col-sm-12">
                        <button class="btn btn-primary" type="submit">Add</button>
                        <a href="{{url('crm_production')}}" class="btn btn-default">Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="customer_modal" tabindex="-1" aria-labelledby="customer_modal_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="customer_modal_label">Add Customer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <div class="modal-body">

                {!! Form::open(['url' => action([\App\Http\Controllers\CrmProductionController::class, 'customerStore']), 'method' => 'post', 'id' => 'customer_add_form']) !!}
                {{ csrf_field() }}

                <div class="row">

                    <div class="form-group col-sm-12">
                    {!! Form::label('name', 'Name:') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
                </div>

                <div class="form-group col-sm-12">
                    {!! Form::label('email', 'Email:') !!}
                    {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
                </div>

                <div class="form-group col-sm-12">
                    {!! Form::label('contact_number', 'Contact Number:') !!}
                    {!! Form::text('contact_number', null, ['class' => 'form-control contact_number', 'id' => 'contact_number', 'maxlength' => '10', 'pattern' => '[0-9]{1}[0-9]{9}']) !!}
                </div>

                <div class="form-group col-sm-12">
                    {!! Form::label('address', 'Address:') !!}
                    {!! Form::textarea('address', null, ['class' => 'form-control', 'id' => 'address']) !!}
                </div>

                    <div class="form-group col-sm-12">
                        {!! Form::label('siteaddress', 'SiteAddress:') !!}
                        {!! Form::textarea('siteaddress', null, ['class' => 'form-control','id' => 'siteaddress']) !!}
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="submitBtn" >Save</button>
                    <a href="{{ url('crm_production') }}" class="btn btn-default" data-dismiss="modal">Cancel</a>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

    <!--for select2 dropdown--->
    <script type="application/javascript">
        $('.select2').select2({
            placeholder: 'Select an option',
        });
    </script>

    <!---for Chechbox---->
    <script>
        function myFunction() {
            var checkBox = document.getElementById("myCheck");
            if (checkBox.checked == true){
                $(".factory-revised").css({ 'display' : '',});
            } else {
                $(".factory-revised").css({ 'display' : 'none',});
            }
        }
    </script>

    <script>
        document.getElementById('material_received_date_from_factory').addEventListener('change', function() {
            var materialReceivedDate = new Date(this.value);
            var today = new Date();

            var timeDifference = today - materialReceivedDate;

            var daysDifference = Math.floor(timeDifference / (1000 * 3600 * 24)); // Convert ms to days

            if (daysDifference < 0) {
                daysDifference = 0;
            }
            document.getElementById('no_of_days_since_ready_for_dispatch').value = daysDifference;
        });
    </script>


   <!---for dynamic input feild tags---->
    <script type="application/javascript">

        function addManStageLot() {

            var uniqueId = makeid(5);
            $(".man_stage_append").append(`
            <div class="man_stages_list_${uniqueId}"}>

                 <div class="form-group col-sm-3">
                     <select class="form-control select2"  style="position: relative !important;" name="dispatch_stage_lots_status_id[]">
                      <option selected disabled>Select Dispatch - Stage / Lot</option>
                      @if(isset($dispatch_stage_lots_status) && count($dispatch_stage_lots_status) > 0)
                      @foreach($dispatch_stage_lots_status as $item)
                     <option value="{{$item->id}}">{{$item->Name}}</option>
                     @endforeach
                      @endif
                     </select>
                 </div>


              <div class="form-group col-sm-3">
                   <input class="form-control"  name="plandispatch_date[]" type="date">
              </div>

               <div class="form-group col-sm-3">
                     <select class="form-control select2"  style="position: relative !important;" name="dispatch_status_id[]" >
                     <option selected disabled>Select Dispatch Status</option>
                     @if(isset($dispatch_status) && count($dispatch_status) > 0)
                     @foreach($dispatch_status as $item)
                    <option value="{{$item->id}}">{{$item->title}}</option>
                     @endforeach
                     @endif
                   </select>
              </div>

               <div class="form-group col-sm-2">
                 <input class="form-control" id="go_down_dispatch_completion_date" name="go_down_dispatch_completion_date[]" type="date">
               </div>

          <div class="form-group col-sm-1">
            <button type="button" onclick="removeManStageLot('${uniqueId}')"><i class="glyphicon glyphicon-trash"></i></button>
          </div>

            </div>
            `);

            $('.select2').select2({
                placeholder: 'Select an option'
            });
        }

        function makeid(length) {
            let result = '';
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const charactersLength = characters.length;
            let counter = 0;
            while (counter < length) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
                counter += 1;
            }
            return result;
        }

        function removeManStageLot(id) {
            $(".man_stages_list_"+id).remove();
        }

        $(document).ready(function() {
            $('#submitBtn').click(function(e) {
                e.preventDefault();
                var formData = {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    contact_number: $('#contact_number').val(),
                    address: $('#address').val(),
                    siteaddress: $('#siteaddress').val(),
                    _token: '{{ csrf_token() }}'
                };

                alert(formData);
                console.log(formData);

                $.ajax({
                    url: "{{ url('crm_production/customerStore') }}",
                    type: 'POST',
                    data: formData,

                    // alert(formData);
                    success: function(response) {
                        if (response.success) {
                            $('#customer_modal').modal('hide');
                            alert(response.message);
                            // Optionally reset the form
                            $('#name').val('');
                            $('#email').val('');
                            $('#contact_number').val('');
                            $('#address').val('');
                            $('#siteaddress').val('');
                        } else {
                            alert('Error: ' + JSON.stringify(response.errors));  // Show validation errors
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Error adding customer.');
                        }
                });
            });
        });

    </script>
@endsection