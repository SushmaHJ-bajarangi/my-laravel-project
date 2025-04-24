@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Production Request Create
        </h1>
{{--        {{$errors}}--}}
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">

                    <form method="post" action="{{url('production_request/store')}}">
                        @csrf
                        <div class="form-group col-sm-6">
                            <label for="crm">CRM:</label>
                            <input class="form-control" id="crm" name="crm" type="text">
                            @error('crm')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="payment_received">Payment Received for Manufacturing Date:</label>
                            <input class="form-control" id="payment_received" name="jobs" type="date">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="crm_confirmation_date">Crm Confirmation Date:</label>
                            <input class="form-control" id="crm_confirmation_date" name="crm_confirmation_date" type="date">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="jobs">Jobs:</label>
                            <input class="form-control" id="jobs" name="jobs" type="text">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Customer Name</label>
                            <select class="form-control" name="customer_name" id="customer_name">
                                <option selected disabled>Select Customer</option>
                                @if(isset($customer) && count($customer) > 0)
                                    @foreach($customer as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="contract_value">Contract Value:</label>
                            <input class="form-control" id="contract_value" name="contract_value" type="number">
                        </div>

                        <div class="form-group col-sm-12">
                            <hr>
                            <label for="stage_of_material">Stage of Material::</label>
                            <div class="row stage_of_material">
                                <div class="som_list">
                                    <div class="form-group col-sm-5">
                                        <label for="">Manufacture Stages</label>
                                        <select class="form-control" required="true" name="stage_of_material[]">
                                            <option selected disabled>Select</option>
                                            @if(isset($stage_of_material) && count($stage_of_material) > 0)
                                                @foreach($stage_of_material as $item)
                                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </div>
                                    <div class="form-group col-sm-5">
                                        <label class="">Note</label>
                                        <input type="text" required="true" name="stage_of_material_note[]" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-1">
                                        <button type="button" onclick="add_som()"><i class="glyphicon glyphicon-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="manufacturing_from_teknix_office">Requested Date for Start of Manufacturing from Teknix Office:</label>
                            <input class="form-control" id="manufacturing_from_teknix_office" name="manufacturing_from_teknix_office" type="date">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="dispatch_request_date_from_teknix_office">Dispatch Request Date from Teknix Office:</label>
                            <input class="form-control" id="dispatch_request_date_from_teknix_office" name="dispatch_request_date_from_teknix_office" type="date">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="dispatch_payment_status">Dispatch Payment Status:</label>
                            <input class="form-control" id="dispatch_payment_status" name="dispatch_payment_status" type="text">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="amount_pending_for_dispatch">Amount Pending for Dispatch in INR:</label>
                            <input class="form-control" id="amount_pending_for_dispatch" name="amount_pending_for_dispatch" type="number">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="manufacturing_status_1">'Manufacturing Status:</label>
                            <input class="form-control" id="manufacturing_status" name="manufacturing_status_1" type="text">
                        </div>

                        <div class="form-group col-sm-12">
                            <hr>
                            <label for="manufacturing_stage_lot">'Manufacturing -Stage / Lot:</label>
                            <div class="row man_stage_append">
                                <div class="man_stages_list">
                                    <div class="form-group col-sm-3">
                                        <label class="">Manufacture By</label>
                                        <input type="text" name="manufacturing_by[]" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label class="">Production Date</label>
                                        <input type="date" name="production_date[]" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label class="">Readiness Date</label>
                                        <input type="date" name="readiness_date[]" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label class="">Manufacture Stages</label>
                                        <select class="form-control" name="manufacturing_stage[]">
                                            <option selected disabled>Select</option>
                                            @if(isset($manufacture_stages) && count($manufacture_stages) > 0)
                                                @foreach($manufacture_stages as $item)
                                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label class="">Manufacture Status</label>
                                        <select class="form-control" name="manufacturing_status[]">
                                            <option selected disabled>Select</option>
                                            @if(isset($manufacture_status) && count($manufacture_status) > 0)
                                                @foreach($manufacture_status as $item)
                                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </div>
                                    <div class="form-group col-sm-1 mt-4">
                                        <button type="button" onclick="addManStageLot()"><i class="glyphicon glyphicon-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <hr>

                        </div>

                        <div class="form-group col-sm-6">
                            <label for="dispatch_status">Dispatch Status:</label>
                            <input class="form-control" id="dispatch_status" name="dispatch_status" type="text">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="dispatch_stage_lot">Dispatch - Stage / Lot:</label>
                            <input class="form-control" id="dispatch_stage_lot" name="dispatch_stage_lot" type="text">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="comments">Comments:</label>
                            <textarea class="form-control" id="comments" name="comments"></textarea>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="dispatch_planned_date">Dispatch Planned Date:</label>
                            <input class="form-control" id="dispatch_stage_lot" name="dispatch_planned_date" type="date">
                        </div>


                        <div class="form-group col-sm-6">
                            <label for="factory_commitment_date">Factory Commitment Date:</label>
                            <input class="form-control" id="factory_commitment_date" name="factory_commitment_date" type="text">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="reason_for_revised_date">Reason For revised Date (Office):</label>
                            <input class="form-control" id="reason_for_revised_date" name="reason_for_revised_date" type="text">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="revised_planed_dispatch_date">Revised Planed Dispatch Date  (Office):</label>
                            <input class="form-control" id="revised_planed_dispatch_date" name="revised_planed_dispatch_date" type="text">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="reason_dispatch_date_factory">Reason Dispatch Date Factory:</label>
                            <input class="form-control" id="reason_dispatch_date_factory" name="reason_dispatch_date_factory" type="date">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="revised_commitment_date_factory">Revised Commitment Date factory:</label>
                            <input class="form-control" id="revised_commitment_date_factory" name="revised_commitment_date_factory" type="text">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="material_readiness">Material Readiness:</label>
                            <input class="form-control" id="material_readiness" name="material_readiness" type="date">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="status_of_completion">Status of Completion:</label>
                            <input class="form-control" id="status_of_completion" name="status_of_completion" type="text">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="no_of_days">No of days:</label>
                            <input class="form-control" id="no_of_days" name="no_of_days" type="number">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="dispatch_date">Dispatch Date:</label>
                            <input class="form-control" id="dispatch_date" name="dispatch_date" type="date">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="specification">Specification:</label>
                            <textarea class="form-control" id="specification" name="specification"></textarea>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="issue ">Issue:</label>
                            <textarea class="form-control" id="issue" name="issue"></textarea>
                            @error('issue')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="address_details">Address Details :</label>
                            <textarea class="form-control" id="address_details" name="address_details"></textarea>
                            @error('address_details')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            <button class="btn btn-primary" type="submit">Add</button>
                            <a href="{{url('production_request')}}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="application/javascript">
        function addManStageLot() {
            var uniqueId = makeid(5);
            $(".man_stage_append").append(`
            <div class="man_stages_list_${uniqueId}"}>
                <div class="form-group col-sm-3">
                                    <input type="text" name="manufacturing_by[]" class="form-control">
                                </div>
                                <div class="form-group col-sm-2">
                                    <input type="date" name="production_date[]" class="form-control">
                                </div>
                                <div class="form-group col-sm-2">
                                    <input type="date" name="readiness_date[]" class="form-control">
                                </div>
                                <div class="form-group col-sm-2">
                                    <select class="form-control" name="manufacturing_stage[]">
                                        <option selected disabled>Select</option>
                                        @if(isset($manufacture_stages) && count($manufacture_stages) > 0)
            @foreach($manufacture_stages as $item)
            <option value="{{$item->id}}">{{$item->title}}</option>
                                            @endforeach
            @endif

            </select>
        </div>
        <div class="form-group col-sm-2">
            <select class="form-control" name="manufacturing_status[]">
                <option selected disabled>Select</option>
@if(isset($manufacture_status) && count($manufacture_status) > 0)
            @foreach($manufacture_status as $item)
            <option value="{{$item->id}}">{{$item->title}}</option>
                                            @endforeach
            @endif
            </select>
        </div>
        <div class="form-group col-sm-1">
            <button type="button" onclick="removeManStageLot('${uniqueId}')"><i class="glyphicon glyphicon-trash"></i></button>
                                </div>
            </div>
            `);
        }

        function add_som() {
            var uniqueId = makeid(5);
            $(".stage_of_material").append(` <div class="som_list_${uniqueId}">
                                                <div class="form-group col-sm-5">
                                                    <select class="form-control" name="stage_of_material[]">
                                                        <option selected disabled>Select</option>
                                                        @if(isset($stage_of_material) && count($stage_of_material) > 0)
            @foreach($stage_of_material as $item)
            <option value="{{$item->id}}">{{$item->title}}</option>
                                                            @endforeach
            @endif
            </select>
        </div>
        <div class="form-group col-sm-5">
            <input type="text" name="stage_of_material_note[]" class="form-control">
        </div>
        <div class="form-group col-sm-1">
            <button type="button" onclick="remove_som('${uniqueId}')"><i class="glyphicon glyphicon-trash"></i></button>
                                                </div>
                                            </div>
            `);
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
        function remove_som(id) {
            $(".som_list_"+id).remove();
        }
    </script>
@endsection
