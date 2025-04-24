
<div class="table-responsive">

    <table class="table display" id="example" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>CRM</th>
            <th>Payment Received for  Manufactruing  Date</th>
            <th>Crm Confirmation Date</th>
            <th>Jobs</th>
            <th>Customer Name</th>
            <th>Contract Value</th>
            <th>Priority</th>
            <th>Manufacturing Confirmation Date (Office)</th>
            <th>Planned Dispatch Date (Office)</th>
            <th>Dispatch Payment Status</th>
            <th>Amount Pending for Dispatch in INR</th>
            <th>Manufacturing Status</th>
            <th>Dispatch Status</th>
            <th>Dispatch - Stage / Lot</th>
            <th>Comments</th>
            <th>Factory Commitment Date</th>
            <th>Reason For revised Date (Office)</th>
            <th>Revised Planed Dispatch Date (Office)</th>
            <th>Reason Dispatch Date Factory</th>
            <th>Revised Commitment Date factory</th>
            <th>Material Readiness</th>
            <th>Status of Completion</th>
            <th>No of days</th>
            <th>Dispatch Date</th>
            <th>Specification</th>
            <th>Issue</th>
            <th>Address Details</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>

        @foreach($data as $item)
        <tr>
            <td>{{ $item->manager }}</td>
            <td>{{ $item->mnf_payment_date }}</td>
            <td>{{ $item->crm_confirmation_date }}</td>
            <td>{{ $item->job_no }}</td>
            <?php $customer = \App\Models\customers::where('id', $item->customer_id)->first() ?>
            <td>{{ $customer->name ?? null }}</td>
            <td>{{ $item->contract_value }}</td>
            <td>{{ $item->priority }}</td>
            <td>{{ $item->mnf_confirmation_date }}</td>
            <td>{{ $item->original_planned_dispatch_date .' '. $item->revised_planned_dispatch_date}}</td>
            <td>{{ $item->dispatch_payment_status }}</td>
            <td>{{ $item->pending_dispatch_amount_inr }}</td>
            <td>{{ $item->manufacturing_status }}</td>
            <td>{{ $item->dispatch_status }}</td>
            <td>{{ $item->dispatch_stage_lot }}</td>
            <td>{{ $item->comments }}</td>
            <td>{{ $item->factory_commitment_date }}</td>
            <td>{{ $item->revised_date_reason }}</td>
            <td>{{ $item->revised_planed_dispatch }}</td>
            <td>{{ $item->dispatch_date_reason_factory }}</td>
            <td>{{ $item->revised_commitment_date_factory }}</td>
            <td>{{ $item->material_readiness }}</td>
            <td>{{ $item->completion_status }}</td>
            <td>{{ $item->no_of_days }}</td>
            <td>{{ $item->dispatch_date }}</td>
            <td>{{ $item->specification }}</td>
            <td>{{ $item->issue }}</td>
            <td>{{ $item->address }}</td>
            <td class="text-center">
                <div class='btn-group'>
                    <form action="{{url('/production_request/delete/'.$item->id)}}" method="POST">
                        @csrf
                        <a href="{{url('production_request/edit/'.$item->id)}}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        <button type="submit"  class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')"><i class="glyphicon glyphicon-trash"></i></button>
                    </form>
                </div>
            </td>
        </tr>

        @endforeach
        </tbody>

    </table>
</div>


