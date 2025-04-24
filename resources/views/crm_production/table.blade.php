<div class="table-responsive">

    <table class="table display" id="example" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>CRM</th>
            <th>Payment Received Manufacturing Date</th>
            <th>Crm Confirmation Date</th>
            <th>Job No. </th>
            <th>Customer Name </th>
            <th>Address Details</th>
            <th>Contract Value</th>
            <th>Request for Production </th>
            <th>Standard / Non standard </th>
            <th>Requested Date for Start of Manufacturing from Teknix Office </th>
            <th>Dispatch Request Date from Teknix Office</th>
            <th>Dispatch Payment Status</th>
            <th>Amount Pending for Dispatch in INR </th>
            <th>Dispatch Comment</th>
            <th>Specifications</th>
            <th>Manufacturing Status</th>
            <th>Manufacturing -Stage / Lot </th>
            <th>Manufacture Completion Date</th>
{{--            <th>Factory Commitment Date</th>--}}
            <th>Manufacture_Comment</th>
            <th>Material Received Date From Factory</th>
            <th>No. Of days since ready for dispatch</th>
            <th>Comments</th>

{{--            <th>Dispatch Status </th>--}}
{{--            <th>Plan dispatch</th>--}}
{{--            <th>Dispatch - Stage / Lot</th>--}}
{{--            <th>Go Down: Dispatch Completion  Date</th>--}}

            <th>Action</th>
        </tr>
        </thead>
         <tbody>

         @foreach($data as $item)
         <tr>
             <?php $crm = \App\Models\Crm::where('id', $item->crm_id)->first() ?>
             <td>{{ $crm->name ?? null }}</td>

             <td>{{ $item->payment_received_manufacturing_date}}</td>
             <td>{{ $item->crm_confirmation_date }}</td>
             <td>{{ $item->job_no }}</td>

             <td>{{ $item->customer_id ?? null }}</td>

             <td>{{ $item->addressu}}</td>

             <td>{{ $item->contract_value}}</td>

             <?php $stage_of_material = \App\Models\StageOfMaterial::where('id', $item->stage_of_materials_id)->first() ?>
             <td>{{ $stage_of_material->title ?? null}}</td>

             <?php  $priority = \App\Models\Priority::where('id', $item->priority_id)->first()?>
             <td>{{ $priority->title ?? null }}</td>

             <td>{{ $item->requested_date_for_start_of_manufacturing_from_teknix_office}}</td>
             <td>{{ $item->dispatch_request_date_from_teknix_office}}</td>

             <?php $dispatch_payments_status = \App\Models\DispatchPaymentStatus::where('id', $item->dispatch_payments_status_id)->first() ?>
             <td>{{ $dispatch_payments_status->Name ?? null }}</td>

             <td>{{ $item->amount_pending_for_dispatch }}</td>

             <td>{{ $item->dispatch_comment }}</td>

             <td>{{ $item->specifications }}</td>

                 <?php $manufacture_status = \App\Models\ManufactureStatus::where('id', $item->manufacture_status_id)->first() ?>
                 <td>{{ $manufacture_status -> title ?? null }}</td>
{{--             <td>  <?php echo $manufacture_status; ?></td>--}}

                 <?php $manufacture_stages = \App\Models\ManufactureStage::where('id', $item->manufacture_stages_id)->first() ?>
                                  <td>{{ $manufacture_stages->title ?? null}}</td>
{{--                 <td>  <?php echo $manufacture_stages; ?></td>--}}

{{--                 <td>{{ $item->factory_commitment_date }}</td>--}}

                 <td>{{ $item->manufacture_completion_date}}</td>

                 <td>{{ $item->manufacture_comment}}</td>

                 <td>{{ $item->material_received_date_from_factory}}</td>
                 <td>{{ $item->no_of_days_since_ready_for_dispatch}}</td>

                 <td>{{ $item->comments }}</td>

{{--                 --}}
{{--                 <?php $dispatch_stage_lots_status = \App\Models\DispatchStageLotStatus::where('id', $item->dispatch_stage_lots_status_id)->first() ?>--}}
{{--                 <td>{{ $dispatch_stage_lots_status->Name ?? null}}</td>--}}

{{--                 <td>{{ $item->plandispatch_date}}</td>--}}

{{--                 <?php $dispatch_status = \App\Models\DispatchStatus::where('id', $item->dispatch_status_id)->first() ?>--}}
{{--                 <td>{{ $dispatch_status ->title ?? null}}</td>--}}
{{--                 --}}{{--                 <td> <?php echo $dispatch_status; ?></td>--}}

{{--                 <td>{{ $item->go_down_dispatch_completion_date }}</td>--}}


                 <td class="text-center">

                 <div class='btn-group'>
                     {!! Form::open(['url' => ['crm_production/delete', $item->id], 'method' => 'post']) !!}
                     <a href="{{ url('crm_production/edit', [$item->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                     {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                     {!! Form::close() !!}
                 </div>

             </td>
         </tr>
         @endforeach

         </tbody>
    </table>
</div>

