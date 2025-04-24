<div class="table-responsive">

    <table class="table" id="example">
        <thead>
        <tr>
            <th>Place</th>
            <th>Job No</th>
            <th>CRM</th>
            <th>Payment Received for Manufactruing Date</th>
            <th>Crm Confirmation Date</th>
            <th>Customer Name</th>
            <th>Address Details</th>
            <th>Specifications</th>
            <th>Car Bracket</th>
            <th>Car Bracket Readiness Status</th>
            <th>Car Bracket Radiness Date</th>
            <th>Cwt Bracket</th>
            <th>Cwt Bracket Radiness Status</th>
            <th>Cwt Bracket Radiness Date</th>
            <th>LD Opening</th>
            <th>LD Finish</th>
            <th>LD Frame Status</th>
            <th>LD Frame Readiness Date</th>
            <th>LD Status</th>
            <th>LD Radiness Date</th>
            <th>Comments</th>
            <th>Machine Channel Type</th>
            <th>Machine Channel Readiness Status</th>
            <th>machine channel Radiness Date</th>
            <th>Machine</th>
            <th>Machine Radiness Status</th>
            <th>machine Radiness Date</th>
            <th>Car Frame</th>
            <th>Car Frame Readiness Status</th>
            <th>Car Frame Radiness Date</th>
            <th>Cwt Frame</th>
            <th>Cwt Frame Status</th>
            <th>Cwt Frame Radiness Date</th>
            <th>Rope Available</th>
            <th>OSG Assy Available</th>
            <th>Comments</th>
            <th>Cabin</th>
            <th>cabin Readiness Status</th>
            <th>cabin Radiness Date</th>
            <th>Controller</th>
            <th>Controller Readiness Status</th>
            <th>Controller Radiness Date</th>
            <th>Car Door Opening</th>
            <th>Car Door Finish</th>
            <th>Car Door Status </th>
            <th>Car Door Radiness Date</th>
            <th>COP & LOP</th>
            <th>COP & LOP Status</th>
            <th>COP & LOP Radiness Date</th>
            <th>Harness</th>
            <th>Harness Readiness Status</th>
            <th>Harness Radiness Date</th>
            <th>Comments</th>
            <th>Full Dispatched Date1</th>
            <th>Car Bracket Available Status</th>
            <th>Car Bracket Available Date</th>
            <th>Car Bracket Dispatch Status</th>
            <th>Car Bracket Dispatch Date</th>
            <th>Cwt Bracket Available Status</th>
            <th>Cwt Bracket Available Date</th>
            <th>Cwt Bracket Dispatch Status</th>
            <th>Cwt Bracket Dispatch Date</th>
            <th>LD Frame Received Date</th>
            <th>LD Frame Dispatch Status</th>
            <th>LD Frame Dispatch Date</th>
            <th>LD Received Date</th>
            <th>LD Dispatch Status</th>
            <th>LD Dispatch Date</th>
            <th>Full Dispatched Date2</th>
            <th>Machine Channel Received Date</th>
            <th>Machine Channel Dispatch Status</th>
            <th>Machine Channel Dispatch Date</th>
            <th>Machine Available Date</th>
            <th>Machine Dispatch Status</th>
            <th>Machine Dispatch Date</th>
            <th>Car Frame Received Date</th>
            <th>Car Frame Dispatch Status </th>
            <th>Car Frame Dispatch Date</th>
            <th>Cwt Frame Received Date</th>
            <th>Cwt Frame Dispatch Status</th>
            <th>Cwt Frame Dispatch Date</th>
            <th>Rope Available Date</th>
            <th>Rope Dispatch Status</th>
            <th>Rope Dispatch Date</th>
            <th>OSG Assy Available Date</th>
            <th>OSG Assy Dispatch Status</th>
            <th>OSG Assy Dispatch Date</th>
            <th>Full Dispatched Date3</th>
            <th>Cabin Received Date</th>
            <th>Cabin Dispatch Status</th>
            <th>Cabin Dispatch Date</th>
            <th>Controller Available Date</th>
            <th>Controller Dispatch Status</th>
            <th>Controller Dispatch Date</th>
            <th>Car Door Received Date</th>
            <th>Car Door Dispatch Status</th>
            <th>Car Door Dispatch Date</th>
            <th>Cop And Lop Received Date</th>
            <th>Cop And Lop Dispatch Status</th>
            <th>Cop And Lop Dispatch Date</th>
            <th>Harness Available Date</th>
            <th>Harness Dispatch Status</th>
            <th>Harness Dispatch Date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>

         @foreach($data as $item)
          <tr>
              <td>{{$item->place}}</td>

              <td>{{ $item->job_no ?? null }}</td>

              <?php $crm = \App\Models\Crm::where('id', $item->crm_id)->first() ?>
              <td>{{ $crm->name ?? null }}</td>

              <td>{{ $item->payment_received_manufacturing_date }}</td>
              <td>{{ $item->crm_confirmation_date }}</td>

              <?php $customer = \App\Models\customers::where('id', $item->customer_id)->first() ?>
              <td>{{ $item->customer_id ?? null }}</td>

              <td>{{ $item->addressu }}</td>
              <td>{{ $item->specifications }}</td>

              <?php $carbracket = \App\Models\CarBracket::where('id', $item->car_bracket)->first() ?>
              <td>{{ $carbracket->name ?? null }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->car_bracket_readiness_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->car_bracket_readiness_date }}</td>

              <?php $cwtbracket = \App\Models\CwtBracket::where('id', $item->cwt_bracket)->first() ?>
              <td>{{ $cwtbracket->name ?? null }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->cwt_bracket_readiness_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->cwt_bracket_readiness_date }}</td>

              <?php $ldopening = \App\Models\LdOpening::where('id', $item->ld_opening)->first() ?>
              <td>{{ $ldopening->name ?? null }}</td>

              <?php $ldfinish = \App\Models\LdFinish::where('id', $item->ld_finish)->first() ?>
              <td>{{ $ldfinish->name ?? null }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->ld_frame_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->ld_frame_readiness_date }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->ld_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->ld_readiness_date }}</td>
              <td>{{ $item->comments }}</td>

              <?php $machinechannel = \App\Models\MachineChannel::where('id', $item->machine_channel_type)->first() ?>
              <td>{{ $machinechannel->name ?? null }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->machine_channel_readiness_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->machine_channel_readiness_date }}</td>

              <?php $machine = \App\Models\Machine::where('id', $item->machine)->first() ?>
              <td>{{ $machine->name ?? null }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->machine_readiness_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->machine_readiness_date }}</td>

              <?php $carframe = \App\Models\CarFrame::where('id', $item->car_frame)->first() ?>
              <td>{{ $carframe->name ?? null }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->car_frame_readiness_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->car_frame_readiness_date }}</td>

              <?php $cwtframe = \App\Models\CwtFrame::where('id', $item->cwt_frame)->first() ?>
              <td>{{ $cwtframe->name ?? null }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->cwt_frame_readiness_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->cwt_frame_readiness_date }}</td>

              <?php $ropeavailable = \App\Models\RopeAvailable::where('id', $item->rope_available)->first() ?>
              <td>{{ $ropeavailable->name ?? null }}</td>

              <?php $osgassyavailable = \App\Models\OSGAssyAvailable::where('id', $item->osg_assy_available)->first() ?>
              <td>{{ $osgassyavailable->name ?? null }}</td>

              <td>{{ $item->comment_after_osg }}</td>

              <?php $ldfinish = \App\Models\LdFinish::where('id', $item->cabin)->first() ?>
              <td>{{ $ldfinish->name ?? null }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->cabin_readiness_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->cabin_readiness_date }}</td>

              <?php $controller = \App\Models\Controller::where('id', $item->controller)->first() ?>
              <td>{{ $controller->name ?? null }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->controller_readiness_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->controller_readiness_date }}</td>

              <?php $cardooropening = \App\Models\CarDoorOpening::where('id', $item->car_door_opening)->first() ?>
              <td>{{ $cardooropening->name ?? null }}</td>

              <?php $ldfinish = \App\Models\LdFinish::where('id', $item->car_door_finish)->first() ?>
              <td>{{ $ldfinish->name ?? null }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->car_door_readiness_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->car_door_readiness_date }}</td>

              <?php $copandlop = \App\Models\CopAndLop::where('id', $item->cop_lop)->first() ?>
              <td>{{ $copandlop->name ?? null }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->cop_lop_readiness_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->cop_lop_readiness_date }}</td>

              <?php $harness = \App\Models\Harness::where('id', $item->harness)->first() ?>
              <td>{{ $harness->name ?? null }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->harness_readiness_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->harness_readiness_date }}</td>
              <td>{{ $item->commentscommentscomments }}</td>
              <td>{{ $item->full_dispatched_date1 }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->car_bracket_available_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->car_bracket_available_date }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->car_bracket_dispatch_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->car_bracket_dispatch_date }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->cwt_bracket_available_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->cwt_bracket_available_date }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->cwt_bracket_dispatch_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->cwt_bracket_dispatch_date }}</td>
              <td>{{ $item->ld_frame_received_date }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->ld_frame_dispatch_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->ld_frame_dispatch_date }}</td>
              <td>{{ $item->ld_received_date }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->ld_dispatch_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->ld_dispatch_date }}</td>
              <td>{{ $item->full_dispatched_date2 }}</td>
              <td>{{ $item->machine_channel_received_date }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->machine_channel_dispatch_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->machine_channel_dispatch_date }}</td>
              <td>{{ $item->machine_available_date }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->machine_dispatch_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->machine_dispatch_date }}</td>
              <td>{{ $item->car_frame_received_date }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->car_frame_dispatch_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->car_frame_dispatch_date }}</td>
              <td>{{ $item->cwt_frame_received_date }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->cwt_frame_dispatch_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->cwt_frame_dispatch_date }}</td>
              <td>{{ $item->rope_available_date }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->rope_dispatch_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->rope_dispatch_date }}</td>
              <td>{{ $item->osg_assy_available_date }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->osg_assy_dispatch_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->osg_assy_dispatch_date }}</td>
              <td>{{ $item->full_dispatched_date3 }}</td>
              <td>{{ $item->cabin_received_date }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->cabin_dispatch_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->cabin_dispatch_date }}</td>
              <td>{{ $item->controller_available_date }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->controller_dispatch_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->controller_dispatch_date }}</td>
              <td>{{ $item->car_door_received_date }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->car_door_dispatch_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->car_door__dispatch_date }}</td>
              <td>{{ $item->cop_lop_received_date }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->cop_lop_dispatch_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->cop_lop__dispatch_date }}</td>
              <td>{{ $item->harness_available_date }}</td>

              <?php $readinessstatus = \App\Models\CarBracketReadinessStatus::where('id', $item->harness_dispatch_status)->first() ?>
              <td>{{ $readinessstatus->title ?? null }}</td>

              <td>{{ $item->harness_dispatch_date }}</td>

              <td class="text-center">
                  <div class='btn-group'>
                      {!! Form::open(['url' => ['job_wise_production/delete', $item->id], 'method' => 'post']) !!}
                      <a href="{{ url('job_wise_production/edit', [$item->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                      {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                      {!! Form::close() !!}
                  </div>
              </td>
              
          </tr>
          @endforeach

        </tbody>
    </table>
</div>