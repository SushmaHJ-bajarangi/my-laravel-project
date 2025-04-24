@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
       CRM Production
    </h1>
</section>

<div class="content">
    @include('adminlte-templates::common.errors')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <form method="post" action="{{url('crm_production/update/'.$data->id)}}">
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
                            <option value="{{$item->id}}" {{$data->crm_id == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="payment_received_for_manufactruing_date">Payment Received for Manufacturing Date :</label>
                        <input class="form-control" value="{{$data->payment_received_manufacturing_date ?? null}}" name="payment_received_manufacturing_date" type="date">
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="crm_confirmation_date">Crm Confirmation Date:</label>
                        <input class="form-control" value="{{$data->crm_confirmation_date ?? null}}" name="crm_confirmation_date" type="date">
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="job_no">Job No:</label>
                        <input class="form-control" value="{{$data->job_no ?? null}}" min="1"  name="job_no" type="number">
                    </div>

                    <div class="form-group col-sm-12">
                        <label>Customer Name</label>
                        <input class ="form-control" id="customer_id"  name="customer_id"  type="text" value="{{$data->customer_id ?? null}}">
{{--                        <select class="form-control select2" style="position: relative !important;" name="customer_id" id="customer_id">--}}
{{--                            <option selected disabled>Select Customer</option>--}}
{{--                            @if(isset($customer) && count($customer) > 0)--}}
{{--                            @foreach($customer as $item)--}}
{{--                            <option value="{{$item->name}}" {{$data->customer_id == $item->name ? 'selected' : ''}}>{{$item->name}}</option>--}}
{{--                            @endforeach--}}
{{--                            @endif--}}
{{--                        </select>--}}
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="addressu">addressu Details:</label>
                        <textarea class="form-control" name="addressu" cols="50" rows="10">{{$data->addressu ?? null}}</textarea>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="contract_value">Contract Value:</label>
                        <input class="form-control"  value="{{$data->contract_value ?? null}}" name="contract_value" type="text">
                    </div>

                    <div class="form-group col-sm-12">
                        <label>Request for Production</label>
                        <select class="form-control select2" style="position: relative !important;" name="stage_of_materials_id" id="stage_of_materials_id">
                            <option selected disabled>Select Request for Production</option>
                            @if(isset($stage_of_material) && count($stage_of_material) > 0)
                            @foreach($stage_of_material as $item)
                            <option value="{{$item->id}}" {{$data->stage_of_materials_id == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-sm-12">
                        <label>Standard / Non standard</label>
                        <select class="form-control select2" style="position: relative !important;" name="priority_id" id="priority_id">
                            <option selected disabled>Select Standard / Non standard</option>
                            @if(isset( $priority) && count( $priority) > 0)
                            @foreach( $priority as $item)
                            <option value="{{$item->id}}" {{$data->priority_id == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="requested_date_for_start_of_manufacturing_from_teknix_office">Requested Date for Start of Manufacturing from Teknix Office:</label>
                        <input class="form-control" value="{{$data->requested_date_for_start_of_manufacturing_from_teknix_office ?? null}}" name="requested_date_for_start_of_manufacturing_from_teknix_office" type="date">
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="dispatch_request_date_from_teknix_office">Dispatch Request Date from Teknix Office:</label>
                        <input class="form-control" value="{{$data->dispatch_request_date_from_teknix_office ?? null}}" name="dispatch_request_date_from_teknix_office" type="date">
                    </div>

                    <div class="form-group col-sm-12">
                        <label>Dispatch Payment Status</label>
                        <select class="form-control select2"  style="position: relative !important;" name="dispatch_payments_status_id" id="dispatch_payments_status_id">
                            <option selected disabled>Dispatch Payment Status</option>
                            @if(isset($dispatch_payments_status) && count($dispatch_payments_status) > 0)
                                @foreach($dispatch_payments_status as $item)
                                    <option value="{{$item->id}}" {{$data->dispatch_payments_status_id == $item->id ? 'selected' : ''}}>{{$item->Name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for=" amount_pending_for_dispatch_in_INR">  Amount Pending for Dispatch in INR:</label>
                        <input class="form-control" value="{{ $data->amount_pending_for_dispatch  ?? null}}" name="amount_pending_for_dispatch" min="0" type="number">
                    </div>


                    <div class="form-group col-sm-12">
                        <label for=" amount_pending_for_dispatch_in_INR"> Comment:</label>
                        <input class="form-control" value="{{ $data->dispatch_comment  ?? null}}" id="dispatch_comment" name="dispatch_comment" type="text">
                    </div>

                    <hr style="clear: both;">
                    <div class="form-group col-sm-12">
                        <label for=""> For Factory use only</label>
                    </div>
                    <hr style="clear: both;">

                    <div class="form-group col-sm-12">
                        <label for="specifications">Specifications:</label>
                        <textarea class="form-control" id="specifications" name="specifications" cols="50" rows="10">{{$data->specifications ?? null}}</textarea>
                    </div>

                    <div class="form-group col-sm-12">
                        <label>Manufacturing Status</label>
                        <select class="form-control select2"  style="position: relative !important;" name="manufacture_status_id" id="manufacture_status_id">
                            <option selected disabled>Select Manufacturing Status</option>
                            @if(isset($manufacture_status) && count($manufacture_status) > 0)
                                @foreach($manufacture_status as $item)
                                    <option value="{{$item->id}}"  {{$data->manufacture_status_id == $item->id ? 'selected' : ''}} >{{$item->title}}</option>
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
                                    <option value="{{$item->id}}"  {{$data->manufacture_stages_id == $item->id ? 'selected' : ''}} >{{$item->title}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                        <div class="form-group col-sm-12">
                            <label for="manufacture_completion_date">Manufacture Completion Date:</label>
                            <input class="form-control" value="{{ $data->manufacture_completion_date ?? null}}"  name="manufacture_completion_date" type="date">
                        </div>

                    <div class="form-group col-sm-12 ckeck1">
                        <label for="myCheck">Is Revised:</label>
                        <input type="checkbox" id="myCheck" onclick="myFunction()" name="is_revised" @if($data->is_revised == 1) checked @endif>
                        <div class="form-group factory-revised col-sm-12" @if($data->is_revised  != 1) style="display:none" @endif>
                            <label for="factory_commitment_date">Factory Commitment Date:</label>
                            <input  id="factory_commitment_date" class="form-control" value="{{ $data->factory_commitment_date  ?? null}}"  name="factory_commitment_date" type="date" >
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                            <label for=" manufacture_comment"> Manufacture Comment:</label>
                            <input class="form-control"value="{{ $data->manufacture_comment ?? null}}" name="manufacture_comment" type="text">
                        </div>

                    <hr style="clear: both;">
                    <div class="form-group col-sm-12">
                        <label for=""> For Godown Use only</label>
                    </div>
                    <hr style="clear: both;">


                        <div class="form-group col-sm-12">
                            <label for="material_received_date_from_factory">Material Received Date From Factory:</label>
                            <input class="form-control" id="material_received_date_from_factory" value="{{ $data->material_received_date_from_factory ?? null}}"  name="material_received_date_from_factory" type="date">
                        </div>
                    <div class="form-group col-sm-12">
                        <label for="no_of_days_since_ready_for_dispatch">No of days since ready for dispatch:</label>
                        <input class="form-control" value="{{ $data->no_of_days_since_ready_for_dispatch}}" id="no_of_days_since_ready_for_dispatch" name="no_of_days_since_ready_for_dispatch" type="number" readonly>
                    </div>

                        <!----Dynamic feild----->
                    <div class="form-group col-sm-12">
                        <hr>
                        <label for="manufacturing_stage_lot">Dispatch</label>
                        <div class="row man_stage_append">

                            @foreach($crm_prod_dispatch as $b)
                                <div class="man_stages_list_{{$b->id}}">

                                    <div class="form-group col-sm-3">
                                        <label for="">Dispatch - Stage / Lot</label>
                                        <select class="form-control select2" name="dispatch_stage_lots_status_id[]">
                                            <option selected disabled>Select Dispatch - Stage / Lot</option>
                                            @foreach($dispatch_stage_lots_status as $m)
                                                <option value="{{$m->id}}" {{$b->dispatch_stage_lots_status_id == $m->id ? 'selected' : ''}}>{{$m->Name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="plandispatch_date">Planned Dispatch Date:</label>
                                        <input type="date" name="plandispatch_date[]" value="{{$b->plandispatch_date ?? null}}" class="form-control">
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="dispatch_status_id">Dispatch Status</label>
                                        <select class="form-control select2" name="dispatch_status_id[]">
                                            <option selected disabled>Select Dispatch Status</option>
                                            @foreach($dispatch_status as $t)
                                                <option value="{{$t->id}}" {{$b->dispatch_status_id == $t->id ? 'selected' : ''}}>{{$t->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label for="go_down_dispatch_completion_date">Go Down: Dispatch Completion Date:</label>
                                        <input type="date" name="go_down_dispatch_completion_date[]" value="{{$b->go_down_dispatch_completion_date ?? null}}" class="form-control">
                                    </div>

                                    <div class="form-group col-sm-1 mt-4">
                                        <button type="button" onclick="removeManStageLot({{$b->id}})"><i class="glyphicon glyphicon-trash"></i></button>
                                    </div>

                                </div>
                            @endforeach
                        </div>


                        <div class="man_stages_list">
                            <div class="form-group col-sm-3">
                                <label>Dispatch - Stage / Lot</label>
                                <select class="form-control select2" name="dispatch_stage_lots_status_id[]">
                                    <option selected disabled>Select Dispatch - Stage / Lot</option>
                                    @foreach($dispatch_stage_lots_status as $item)
                                        <option value="{{$item->id}}">{{$item->Name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-3">
                                <label for="plandispatch_date">Planned Dispatch Date:</label>
                                <input class="form-control" name="plandispatch_date[]" type="date">
                            </div>

                            <div class="form-group col-sm-3">
                                <label>Dispatch Status</label>
                                <select class="form-control select2" name="dispatch_status_id[]">
                                    <option selected disabled>Select Dispatch Status</option>
                                    @foreach($dispatch_status as $item)
                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-2">
                                <label for="go_down_dispatch_completion_date">Go Down: Dispatch Completion Date:</label>
                                <input class="form-control" name="go_down_dispatch_completion_date[]" type="date">
                            </div>

                        <div class="form-group col-sm-1 mt-4">
                            <button type="button" onclick="addManStageLot()"><i class="glyphicon glyphicon-plus"></i></button>
                        </div>

                        </div>
                        <hr>
                    </div>

                    <!----End of Dynamic feild----->

                        <div class="form-group col-sm-12">
                        <label for=" comments">  comments:</label>
                        <input class="form-control" value="{{ $data->comments  ?? null}}" name="comments" type="text">
                    </div>


                    <!-- Submit Field -->
                    <div class="form-group col-sm-12">
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a href="{{url('crm_production')}}" class="btn btn-default">Cancel</a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

    <script type="application/javascript">
        $('.select2').select2({
            placeholder: 'Select an option'
        });
    </script>

<!---for Chechbox---->
<script>
    function myFunction()
    {
        var checkBox = document.getElementById("myCheck");
        if (checkBox.checked == true){
            $(".factory-revised").css({ 'display' : '',});
        } else {
            $(".factory-revised").css({ 'display' : 'none',});
        }
    }
</script>

<!---for dynamic input feild tags---->
<script type="application/javascript">

    function addManStageLot() {
        var uniqueId = makeid(5);

        $(".man_stage_append").append(`
        <div class="man_stages_list_${uniqueId}">

            <!-- Dispatch Stage/Lot Field (empty) -->
            <div class="form-group col-sm-3">
                <label>Dispatch - Stage / Lot</label>
                <select class="form-control select2" name="dispatch_stage_lots_status_id[]">
                    <option selected disabled>Select Dispatch - Stage / Lot</option>
                    @foreach($dispatch_stage_lots_status as $item)
                  <option value="{{$item->id}}">{{$item->Name}}</option>
                    @endforeach
                </select>
            </div>

    <!-- Planned Dispatch Date Field (empty) -->
    <div class="form-group col-sm-3">
        <label for="plandispatch_date">Planned Dispatch Date:</label>
        <input class="form-control" name="plandispatch_date[]" type="date">
    </div>

    <!-- Dispatch Status Field (empty) -->
    <div class="form-group col-sm-3">
        <label>Dispatch Status</label>
        <select class="form-control select2" name="dispatch_status_id[]">
            <option selected disabled>Select Dispatch Status</option>
          @foreach($dispatch_status as $item)
        <option value="{{$item->id}}">{{$item->title}}</option>
         @endforeach
        </select>
    </div>

    <!-- Go Down Dispatch Completion Date Field (empty) -->
    <div class="form-group col-sm-2">
        <label for="go_down_dispatch_completion_date">Go Down: Dispatch Completion Date:</label>
        <input class="form-control" name="go_down_dispatch_completion_date[]" type="date">
    </div>

    <!-- Trash Icon to remove the field -->
    <div class="form-group col-sm-1 mt-4">
        <button type="button" onclick="removeManStageLot('${uniqueId}')"><i class="glyphicon glyphicon-trash"></i></button>
            </div>
        </div>
    `);

        $('.select2').select2({
            placeholder: 'Select an option'
        });
    }

        function removeManStageLot(uniqueId) {
            $(".man_stages_list_" + uniqueId).remove();
        }

        function makeid(length) {
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            var counter = 0;
            while (counter < length) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
                counter += 1;
            }
            return result;
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
@endsection