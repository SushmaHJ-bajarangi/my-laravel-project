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
                    <form method="post" action="{{url('manufacture_production/store')}}">
                        @csrf

                        <div class="form-group col-sm-6">
                            {!! Form::label('place', 'Place:') !!}
                            {!! Form::text('place', null, ['class' => 'form-control','id'=>'place']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('crm', 'CRM:') !!}
                            {!! Form::text('crm', null, ['class' => 'form-control','id'=>'crm']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('payment_received', 'Payment Received for Manufacturing Date:') !!}
                            {!! Form::date('payment_received', null, ['class' => 'form-control','id'=>'payment_received']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('crm_confirmation_date', 'Crm Confirmation Date:') !!}
                            {!! Form::date('crm_confirmation_date', null, ['class' => 'form-control','id'=>'crm_confirmation_date']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('jobs', 'Jobs:') !!}
                            {!! Form::text('jobs', null, ['class' => 'form-control','id'=>'jobs']) !!}
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
                            {!! Form::label('contract_value', 'Contract Value:') !!}
                            {!! Form::number('contract_value', null, ['class' => 'form-control','id'=>'contract_value']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            <hr>
                            {!! Form::label('stage_of_material', 'Stage of Material:') !!}
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
                            <label class="">Priority</label>
                            <select class="form-control" name="priority">
                                <option selected disabled>Select</option>
                                @if(isset($priority) && count($priority) > 0)
                                    @foreach($priority as $item)
                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                    @endforeach
                                @endif

                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('manufacturing_confirmation_date', 'Manufacturing Confirmation Date (Office):') !!}
                            {!! Form::date('manufacturing_confirmation_date', null, ['class' => 'form-control','id'=>'manufacturing_confirmation_date']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('original_planned_dispatch_date', 'Original Planned Dispatch Date (Office):') !!}
                            {!! Form::date('original_planned_dispatch_date', null, ['class' => 'form-control','id'=>'original_planned_dispatch_date']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('revised_planned_dispatch_date', 'Revised Planned Dispatch Date (Office):') !!}
                            {!! Form::date('revised_planned_dispatch_date', null, ['class' => 'form-control','id'=>'revised_planned_dispatch_date']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('dispatch_payment_status', 'Dispatch Payment Status:') !!}
                            {!! Form::text('dispatch_payment_status', null, ['class' => 'form-control','id'=>'dispatch_payment_status']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('amount_pending_for_dispatch', 'Amount Pending for Dispatch in INR:') !!}
                            {!! Form::number('amount_pending_for_dispatch', null, ['class' => 'form-control','id'=>'amount_pending_for_dispatch']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('manufacturing_status_1', 'Manufacturing Status:') !!}
                            {!! Form::text('manufacturing_status_1', null, ['class' => 'form-control','id'=>'manufacturing_status']) !!}
                        </div>


                        <div class="form-group col-sm-12">
                            <hr>
                            {!! Form::label('manufacturing_stage_lot', 'Manufacturing -Stage / Lot:') !!}

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
                            {!! Form::label('dispatch_status', 'Dispatch Status:') !!}
                            {!! Form::text('dispatch_status', null, ['class' => 'form-control','id'=>'dispatch_status']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('dispatch_stage_lot', 'Dispatch - Stage / Lot:') !!}
                            {!! Form::text('dispatch_stage_lot', null, ['class' => 'form-control','id'=>'dispatch_stage_lot']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('comments', 'comments:') !!}
                            {!! Form::text('comments', null, ['class' => 'form-control','id'=>'comments']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('factory_commitment_date', 'Factory Commitment Date:') !!}
                            {!! Form::text('factory_commitment_date', null, ['class' => 'form-control','id'=>'factory_commitment_date' ]) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('reason_for_revised_date', 'Reason For revised Date (Office):') !!}
                            {!! Form::text('reason_for_revised_date', null, ['class' => 'form-control','id'=>'reason_for_revised_date' ]) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('revised_planed_dispatch_date', 'Revised Planed Dispatch Date  (Office):') !!}
                            {!! Form::text('revised_planed_dispatch_date', null, ['class' => 'form-control','id'=>'revised_planed_dispatch_date' ]) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('reason_dispatch_date_factory', 'Reason Dispatch Date Factory:') !!}
                            {!! Form::text('reason_dispatch_date_factory', null, ['class' => 'form-control','id'=>'reason_dispatch_date_factory' ]) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('revised_commitment_date_factory', 'Revised Commitment Date factory:') !!}
                            {!! Form::text('revised_commitment_date_factory', null, ['class' => 'form-control','id'=>'revised_commitment_date_factory' ]) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('material_readiness', 'Material Readiness:') !!}
                            {!! Form::date('material_readiness', null, ['class' => 'form-control','id'=>'material_readiness' ]) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('status_of_completion', 'Status of Completion:') !!}
                            {!! Form::text('status_of_completion', null, ['class' => 'form-control','id'=>'status_of_completion' ]) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('no_of_days', 'No of days:') !!}
                            {!! Form::number('no_of_days', null, ['class' => 'form-control','id'=>'no_of_days' ]) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('dispatch_date', 'Dispatch Date:') !!}
                            {!! Form::date('dispatch_date', null, ['class' => 'form-control','id'=>'dispatch_date' ]) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('specification', 'Specification:') !!}
                            {!! Form::textarea('specification', null, ['class' => 'form-control','id'=>'specification' ]) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('issue', 'Issue:') !!}
                            {!! Form::textarea('issue', null, ['class' => 'form-control','id'=>'issue' ]) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('address_details', 'Address Details :') !!}
                            {!! Form::textarea('address_details', null, ['class' => 'form-control','id'=>'address_details' ]) !!}
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            <button class="btn btn-primary" type="submit">Add</button>
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