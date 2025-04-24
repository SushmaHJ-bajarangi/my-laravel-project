@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Manufacture & Dispatch Traction
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <form method="post" action="{{url('manufacture_production/update/'.$data->id)}}">
                        @csrf
                        <div class="form-group col-sm-6">
                            <label>CRM:</label>
                            <input type="text" name="crm" class="form-control" value="{{$data->manager ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Payment Received for Manufacturing Date:</label>
                            <input type="date" name="payment_received" class="form-control" value="{{$data->mnf_payment_date ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Crm Confirmation Date:</label>
                            <input type="date" name="crm_confirmation_date" class="form-control" value="{{$data->crm_confirmation_date ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Jobs:</label>
                            <input type="text" name="jobs" class="form-control" value="{{$data->job_no ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Customer Name</label>
                            <select class="form-control" name="customer_name" id="customer_name">
                                <option selected disabled>Select Customer</option>
                                @if(isset($customer) && count($customer) > 0)
                                    @foreach($customer as $item)
                                        <option value="{{$item->id}}" {{$data->customer_id == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                                    @endforeach
                                @endif

                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Contract Value:</label>
                            <input type="number" name="contract_value" class="form-control" value="{{$data->contract_value ?? null}}">
                        </div>

                        <div class="form-group col-sm-12">
                            <hr>
                            <label>Stage of Material:</label>
                            <div class="row stage_of_material">
                                @if(isset($p_som) && count($p_som) > 0)
                                    @foreach($p_som as $key => $item)
                                        <div class="som_list_{{$item->id}}">
                                            <div class="form-group col-sm-5">
                                                @if($key == 0) <label for="">Manufacture Stages</label> @endif
                                                <select class="form-control" required="true" name="stage_of_material[]">
                                                    <option selected disabled>Select</option>
                                                    @if(isset($stage_of_material) && count($stage_of_material) > 0)
                                                        @foreach($stage_of_material as $y)
                                                            <option value="{{$y->id}}" {{$item->som_id == $y->id ? 'selected' : ''}}>{{$y->title}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-5">
                                                @if($key == 0) <label for="">Note</label> @endif
                                                <input type="text" value="{{$item->note ?? null}}" required="true" name="stage_of_material_note[]" class="form-control">
                                            </div>
                                            @if($key == 0)
                                            <div class="form-group col-sm-1">
                                                <button type="button" onclick="add_som()"><i class="glyphicon glyphicon-plus"></i></button>
                                            </div>
                                            @else

{{--                                                <div class="form-group col-sm-1">--}}
{{--                                                    <button type="button" onclick="remove_som({{$item->id}})"><i class="glyphicon glyphicon-trash"></i></button>--}}
{{--                                                </div>--}}

                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="som_list">
                                        <div class="form-group col-sm-5">
                                            <label for="">Manufacture Stages</label>
                                            <select class="form-control" required="true" name="stage_of_material[]">
                                                <option selected disabled>Select</option>
                                                @if(isset($stage_of_material) && count($stage_of_material) > 0)
                                                    @foreach($stage_of_material as $x)
                                                        <option value="{{$x->id}}">{{$x->title}}</option>
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
                                @endif
                            </div>
                            <hr>
                        </div>

                        <div class="form-group col-sm-6">
                            <label class="">Priority</label>
                            <select class="form-control" name="priority">
                                <option selected disabled>Select</option>
                                @if(isset($priority) && count($priority) > 0)
                                    @foreach($priority as $item)
                                        <option value="{{$item->id}}" {{$data->priority == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                                    @endforeach
                                @endif

                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Manufacturing Confirmation Date (Office):</label>
                            <input type="date" name="manufacturing_confirmation_date" class="form-control" value="{{$data->mnf_confirmation_date ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Original Planned Dispatch Date (Office):</label>
                            <input type="date" name="original_planned_dispatch_date" class="form-control" value="{{$data->original_planned_dispatch_date ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Revised Planned Dispatch Date (Office):</label>
                            <input type="date" name="revised_planned_dispatch_date" class="form-control" value="{{$data->revised_planned_dispatch_date ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Dispatch Payment Status:</label>
                            <input type="text" name="dispatch_payment_status" class="form-control" value="{{$data->dispatch_payment_status ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Amount Pending for Dispatch in INR:</label>
                            <input type="number" name="amount_pending_for_dispatch" class="form-control" value="{{$data->pending_dispatch_amount_inr ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Manufacturing Status:</label>
                            <input type="text" name="manufacturing_status_1" class="form-control" value="{{$data->manufacturing_status ?? null}}">
                        </div>


                        <div class="form-group col-sm-12">
                            <hr>
                            <label>Manufacturing -Stage / Lot:</label>
                            <div class="row man_stage_append">
                                @if(isset($p_mns) && count($p_mns) > 0)
                                    @foreach($p_mns as $a => $b)
                                        <div class="man_stages_list_{{$b->id}}">
                                                <div class="form-group col-sm-3">
                                                    @if($a == 0) <label for="">Manufacture By</label> @endif
                                                    <input type="text" name="manufacturing_by[]" value="{{$b->mf_by ?? null}}" class="form-control">
                                                </div>
                                                <div class="form-group col-sm-2">
                                                    @if($a == 0) <label for="">Production Date</label> @endif
                                                    <input type="date" name="production_date[]" value="{{$b->production_date ?? null}}" class="form-control">
                                                </div>
                                                <div class="form-group col-sm-2">
                                                    @if($a == 0) <label for="">Readiness Date</label> @endif
                                                    <input type="date" name="readiness_date[]" value="{{$b->readiness_date ?? null}}" class="form-control">
                                                </div>
                                                <div class="form-group col-sm-2">
                                                    @if($a == 0) <label for="">Manufacture Stages</label> @endif
                                                    <select class="form-control" name="manufacturing_stage[]">
                                                        <option selected disabled>Select</option>
                                                        @if(isset($manufacture_stages) && count($manufacture_stages) > 0)
                                                            @foreach($manufacture_stages as $t)
                                                                <option value="{{$t->id}}" {{$b->ms_id == $t->id ? 'selected' : ''}}>{{$t->title}}</option>
                                                            @endforeach
                                                        @endif

                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-2">
                                                    @if($a == 0) <label for="">Manufacture Status</label> @endif
                                                    <select class="form-control" name="manufacturing_status[]">
                                                        <option selected disabled>Select</option>
                                                        @if(isset($manufacture_status) && count($manufacture_status) > 0)
                                                            @foreach($manufacture_status as $m)
                                                                <option value="{{$m->id}}" {{$b->status == $m->id ? 'selected' : ''}}>{{$m->title}}</option>
                                                            @endforeach
                                                        @endif

                                                    </select>
                                                </div>
                                                @if($a == 0)
                                                <div class="form-group col-sm-1 mt-4">
                                                    <button type="button" onclick="addManStageLot()"><i class="glyphicon glyphicon-plus"></i></button>
                                                </div>
                                                @else
{{--                                                <div class="form-group col-sm-1">--}}
{{--                                                    <button type="button" onclick="removeManStageLot({{$b->id}})"><i class="glyphicon glyphicon-trash"></i></button>--}}
{{--                                                </div>--}}
                                                @endif
                                            </div>
                                    @endforeach
                                @else
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
                                @endif
                            </div>
                            <hr>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Dispatch Status:</label>
                            <input type="text" name="dispatch_status" class="form-control" value="{{$data->dispatch_status ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Dispatch - Stage / Lot:</label>
                            <input type="text" name="dispatch_stage_lot" class="form-control" value="{{$data->dispatch_stage_lot ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Comments:</label>
                            <textarea class="form-control" name="comments">{{$data->comments ?? null}}</textarea>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Factory Commitment Date:</label>
                            <input type="text" name="factory_commitment_date" class="form-control" value="{{$data->factory_commitment_date ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Reason For revised Date (Office):</label>
                            <input type="text" name="reason_for_revised_date" class="form-control" value="{{$data->revised_date_reason ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Revised Planed Dispatch Date  (Office):</label>
                            <input type="text" name="revised_planed_dispatch_date" class="form-control" value="{{$data->revised_planed_dispatch ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Reason Dispatch Date Factory:</label>
                            <input type="text" name="reason_dispatch_date_factory" class="form-control" value="{{$data->dispatch_date_reason_factory ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Revised Commitment Date factory:</label>
                            <input type="text" name="revised_commitment_date_factory" class="form-control" value="{{$data->revised_commitment_date_factory ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Material Readiness:</label>
                            <input type="date" name="material_readiness" class="form-control" value="{{$data->material_readiness ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Status of Completion:</label>
                            <input type="text" name="status_of_completion" class="form-control" value="{{$data->completion_status ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>No of days:</label>
                            <input type="number" name="no_of_days" class="form-control" value="{{$data->no_of_days ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Dispatch Date:</label>
                            <input type="date" name="dispatch_date" class="form-control" value="{{$data->dispatch_date ?? null}}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Specification:</label>
                            <textarea class="form-control" name="specification">{{$data->specification ?? null}}</textarea>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Issue:</label>
                            <textarea class="form-control" name="issue">{{$data->issue ?? null}}</textarea>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Address Details:</label>
                            <textarea class="form-control" name="address_details">{{$data->address ?? null}}</textarea>
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="{{url('manufacture_production')}}" class="btn btn-default">Cancel</a>
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