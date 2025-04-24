<?php

namespace App\Exports;

use App\Models\JobWiseProduction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Crm;
use App\Models\customers;
use App\Models\CrmProduction;
use App\Models\CarBracket;
use App\Models\CarBracketReadinessStatus;
use App\Models\CwtBracket;
use App\Models\LdOpening;
use App\Models\LdFinish;
use App\Models\MachineChannel;
use App\Models\Machine;
use App\Models\CwtFrame;
use App\Models\CarFrame;
use App\Models\RopeAvailable;
use App\Models\OSGAssyAvailable;

use App\Models\Controller;
use App\Models\CarDoorOpening;
use App\Models\CopAndLop;
use App\Models\Harness;

class JobWiseProductionExport implements FromCollection,WithHeadings
{
    public function collection()
    {
        $jobwiseproductions = JobWiseProduction::all();

        return $jobwiseproductions->map(function ($jobwiseproduction , $index) {

            $relatedCrm = Crm::find($jobwiseproduction->crm_id );
            $relatedCustomer = customers::find($jobwiseproduction->customer_id);
            $relatedJobNo = CrmProduction::find($jobwiseproduction->job_no);
            $relatedcarbracket = CarBracket::find($jobwiseproduction->car_bracket);
            $relatedCarBracketReadinessStatus = CarBracketReadinessStatus::find($jobwiseproduction->car_bracket_readiness_status);
            $relatedCwtBracket = CwtBracket::find($jobwiseproduction->cwt_bracket);
            $relatedCwtBracketReadinessStatus = CarBracketReadinessStatus::find($jobwiseproduction->cwt_bracket_readiness_status);
            $relatedLdOpening = LdOpening::find($jobwiseproduction->ld_opening);
            $relatedLdFinish = LdFinish::find($jobwiseproduction->ld_finish);
            $relatedLdFrameStatus = CarBracketReadinessStatus::find($jobwiseproduction->ld_frame_status);
            $relatedLdStatus = CarBracketReadinessStatus::find($jobwiseproduction->ld_status);
            $relatedMachineChannel = MachineChannel::find($jobwiseproduction->machine_channel_type);
            $relatedMachineChannelReadinessStatus = CarBracketReadinessStatus::find($jobwiseproduction->machine_channel_readiness_status);
            $relatedMachine = Machine::find($jobwiseproduction->machine);
            $relatedMachineReadinessStatus = CarBracketReadinessStatus::find($jobwiseproduction->machine_readiness_status);
            $relatedCarFrame = CarFrame::find($jobwiseproduction->car_frame);
            $relatedCarFrameReadinessStatus = CarBracketReadinessStatus::find($jobwiseproduction->car_frame_readiness_status);
            $relatedCwtFrame = CwtFrame::find($jobwiseproduction->cwt_frame);
            $relatedCwtFrameReadinessStatus = CarBracketReadinessStatus::find($jobwiseproduction->cwt_frame_readiness_status);
            $relatedRopeAvailable = RopeAvailable::find($jobwiseproduction->rope_available);
            $relatedOsgAssyAvailable = OSGAssyAvailable::find($jobwiseproduction->osg_assy_available);
            $relatedCabin = LdFinish::find($jobwiseproduction->cabin);
            $relatedCabinReadinessStatus = CarBracketReadinessStatus::find($jobwiseproduction->cabin_readiness_status);
            $relatedController = Controller::find($jobwiseproduction->controller);
            $relatedControllerReadinessStatus = CarBracketReadinessStatus::find($jobwiseproduction->controller_readiness_status);
            $relatedCarDoorOpening = CarDoorOpening::find($jobwiseproduction->car_door_opening);
            $relatedCarDoorFinish = LdFinish::find($jobwiseproduction->car_door_finish);

            $relatedCarDoorReadinessStatus = CarBracketReadinessStatus::find($jobwiseproduction->car_door_readiness_status);
            $relatedCopAndLop = CopAndLop::find($jobwiseproduction->cop_lop);
            $relatedCopLopReadinessStatus = CarBracketReadinessStatus::find($jobwiseproduction->cop_lop_readiness_status);
            $relatedHarness = Harness::find($jobwiseproduction->harness);
            $relatedHarnessReadinessStatus = CarBracketReadinessStatus::find($jobwiseproduction->harness_readiness_status);
            $relatedCarBracketAvailableStatus = CarBracketReadinessStatus::find($jobwiseproduction->car_bracket_available_status);
            $relatedCarBracketDispatchStatus = CarBracketReadinessStatus::find($jobwiseproduction->car_bracket_dispatch_status);
            $relatedCwtBracketAvailableStatus = CarBracketReadinessStatus::find($jobwiseproduction->cwt_bracket_available_status);
            $relatedCwtBracketDispatchStatus = CarBracketReadinessStatus::find($jobwiseproduction->cwt_bracket_dispatch_status);
            $relatedLdFrameDispatchStatus = CarBracketReadinessStatus::find($jobwiseproduction->ld_frame_dispatch_status);
            $relatedLdDispatchStatus = CarBracketReadinessStatus::find($jobwiseproduction->ld_dispatch_status);

            $relatedMachineChannelDispatchStatus = CarBracketReadinessStatus::find($jobwiseproduction->machine_channel_dispatch_status);
            $relatedMachineDispatchStatus = CarBracketReadinessStatus::find($jobwiseproduction->machine_dispatch_status);
            $relatedCarFrameDispatchStatus = CarBracketReadinessStatus::find($jobwiseproduction->car_frame_dispatch_status);
            $relatedCwtFrameDispatchStatus = CarBracketReadinessStatus::find($jobwiseproduction->cwt_frame_dispatch_status);
            $relatedRopeDispatchStatus = CarBracketReadinessStatus::find($jobwiseproduction->rope_dispatch_status);
            $relatedOsgAssyDispatchStatus = CarBracketReadinessStatus::find($jobwiseproduction->osg_assy_dispatch_status);

            $relatedCabinDispatchStatus = CarBracketReadinessStatus::find($jobwiseproduction->cabin_dispatch_status);
            $relatedControllerDispatchStatus = CarBracketReadinessStatus::find($jobwiseproduction->controller_dispatch_status);
            $relatedCarDoorDispatchStatus = CarBracketReadinessStatus::find($jobwiseproduction->car_door_dispatch_status);
            $relatedCopLopDispatchStatus = CarBracketReadinessStatus::find($jobwiseproduction->cop_lop_dispatch_status);
            $relatedHarnessDispatchStatus = CarBracketReadinessStatus::find($jobwiseproduction->harness_dispatch_status);


            return
                [
                    $index + 1,
                    $jobwiseproduction->place,
                    $relatedJobNo ? $relatedJobNo->job_no : null,
                    $relatedCrm ? $relatedCrm->name : null,
                    $jobwiseproduction->payment_received_manufacturing_date,
                    $jobwiseproduction->crm_confirmation_date,
                    $relatedCustomer ? $relatedCustomer->name : null,
                    $jobwiseproduction->addressu,
                    $jobwiseproduction->specifications,

                    $relatedcarbracket ? $relatedcarbracket->name : null,
                    $relatedCarBracketReadinessStatus ? $relatedCarBracketReadinessStatus->title : null,
                    $jobwiseproduction->car_bracket_readiness_date,
                    $relatedCwtBracket ? $relatedCwtBracket->name :null,
                    $relatedCwtBracketReadinessStatus ? $relatedCwtBracketReadinessStatus->title : null,
                    $jobwiseproduction->cwt_bracket_readiness_date,
                    $relatedLdOpening ? $relatedLdOpening->name : null,
                    $relatedLdFinish ? $relatedLdFinish->name : null,
                    $relatedLdFrameStatus ? $relatedLdFrameStatus->title :null,
                    $jobwiseproduction->ld_frame_readiness_date,
                    $relatedLdStatus ? $relatedLdStatus->title : null,
                    $jobwiseproduction->ld_readiness_date,
                    $jobwiseproduction->comments,

                    $relatedMachineChannel ? $relatedMachineChannel->name : null,
                    $relatedMachineChannelReadinessStatus ? $relatedMachineChannelReadinessStatus->title : null,
                    $jobwiseproduction->machine_channel_readiness_date,
                    $relatedMachine ? $relatedMachine->name : null,
                    $relatedMachineReadinessStatus ? $relatedMachineReadinessStatus->title : null,
                    $jobwiseproduction->machine_readiness_date,
                    $relatedCarFrame ? $relatedCarFrame->name : null,
                    $relatedCarFrameReadinessStatus ? $relatedCarFrameReadinessStatus->title : null,
                    $jobwiseproduction->car_frame_readiness_date,
                    $relatedCwtFrame ? $relatedCwtFrame->name : null,
                    $relatedCwtFrameReadinessStatus ? $relatedCwtFrameReadinessStatus->title : null,
                    $jobwiseproduction->cwt_frame_readiness_date,
                    $relatedRopeAvailable ? $relatedRopeAvailable->name : null,
                    $relatedOsgAssyAvailable ? $relatedOsgAssyAvailable->name : null,
                    $jobwiseproduction->comment_after_osg,

                    $relatedCabin ? $relatedCabin->name : null,
                    $relatedCabinReadinessStatus ? $relatedCabinReadinessStatus->title : null,
                    $jobwiseproduction->cabin_readiness_date,
                    $relatedController ? $relatedController->name : null,
                    $relatedControllerReadinessStatus ? $relatedControllerReadinessStatus->title : null,
                    $jobwiseproduction->controller_readiness_date,
                    $relatedCarDoorOpening ? $relatedCarDoorOpening->name : null,
                    $relatedCarDoorFinish ?$relatedCarDoorFinish->name : null,
                    $relatedCarDoorReadinessStatus ? $relatedCarDoorReadinessStatus->title : null,
                    $jobwiseproduction->car_door_readiness_date,
                    $relatedCopAndLop ? $relatedCopAndLop->name : null,
                    $relatedCopLopReadinessStatus ?$relatedCopLopReadinessStatus->title : null,
                    $jobwiseproduction->cop_lop_readiness_date,
                    $relatedHarness ? $relatedHarness->name : null,
                    $relatedHarnessReadinessStatus ? $relatedHarnessReadinessStatus->title :null,
                    $jobwiseproduction->harness_readiness_date,
                    $jobwiseproduction->commentscommentscomments,

                    $jobwiseproduction->is_revised ? 1 : 0,
                    $jobwiseproduction->full_dispatched_date1,
                    $relatedCarBracketAvailableStatus ? $relatedCarBracketAvailableStatus->title :null,
                    $jobwiseproduction->car_bracket_available_date,
                    $relatedCarBracketDispatchStatus ? $relatedCarBracketDispatchStatus->title :null,
                    $jobwiseproduction->car_bracket_dispatch_date,
                    $relatedCwtBracketAvailableStatus ? $relatedCwtBracketAvailableStatus->title :null,
                    $jobwiseproduction->cwt_bracket_available_date,
                    $relatedCwtBracketDispatchStatus ? $relatedCwtBracketDispatchStatus->title :null,
                    $jobwiseproduction->cwt_bracket_dispatch_date,
                    $jobwiseproduction->ld_frame_received_date,
                    $relatedLdFrameDispatchStatus ? $relatedLdFrameDispatchStatus->title :null,
                    $jobwiseproduction->ld_frame_dispatch_date,
                    $jobwiseproduction->ld_received_date,
                    $relatedLdDispatchStatus ? $relatedLdDispatchStatus->title :null,
                    $jobwiseproduction->ld_dispatch_date,

                    $jobwiseproduction->is_checkedbox ? 1 : 0,
                    $jobwiseproduction->full_dispatched_date2,
                    $jobwiseproduction->machine_channel_received_date,
                    $relatedMachineChannelDispatchStatus ? $relatedMachineChannelDispatchStatus->title : null,
                    $jobwiseproduction->machine_channel_dispatch_date,
                    $jobwiseproduction->machine_available_date,
                    $relatedMachineDispatchStatus ? $relatedMachineDispatchStatus->title : null,
                    $jobwiseproduction->machine_dispatch_date,
                    $jobwiseproduction->car_frame_received_date,
                    $relatedCarFrameDispatchStatus ? $relatedCarFrameDispatchStatus->title : null,
                    $jobwiseproduction->car_frame_dispatch_date,
                    $jobwiseproduction->cwt_frame_received_date,
                    $relatedCwtFrameDispatchStatus ? $relatedCwtFrameDispatchStatus->title : null,
                    $jobwiseproduction->cwt_frame_dispatch_date,
                    $jobwiseproduction->rope_available_date,
                    $relatedRopeDispatchStatus ? $relatedRopeDispatchStatus->title : null,
                    $jobwiseproduction->rope_dispatch_date,
                    $jobwiseproduction->osg_assy_available_date,
                    $relatedOsgAssyDispatchStatus ? $relatedOsgAssyDispatchStatus->title : null,
                    $jobwiseproduction->osg_assy_dispatch_date,

                    $jobwiseproduction->is_check ? 1 : 0,
                    $jobwiseproduction->full_dispatched_date3,
                    $jobwiseproduction->cabin_received_date,
                    $relatedCabinDispatchStatus ? $relatedCabinDispatchStatus->title :null,
                    $jobwiseproduction->cabin_dispatch_date,
                    $jobwiseproduction->controller_available_date,
                    $relatedControllerDispatchStatus ? $relatedControllerDispatchStatus->title :null,
                    $jobwiseproduction->controller_dispatch_date,
                    $jobwiseproduction->car_door_received_date,
                    $relatedCarDoorDispatchStatus ? $relatedCarDoorDispatchStatus->title :null,
                    $jobwiseproduction->car_door__dispatch_date,
                    $jobwiseproduction->cop_lop_received_date,
                    $relatedCopLopDispatchStatus ? $relatedCopLopDispatchStatus->title :null,
                    $jobwiseproduction->cop_lop__dispatch_date,
                    $jobwiseproduction->harness_available_date,
                    $relatedHarnessDispatchStatus ? $relatedHarnessDispatchStatus->title :null,
                    $jobwiseproduction->harness_dispatch_date,
                ];
        });
    }

    public function headings():array
    {
        return [
            '#',
            'Place',
            'Job No',
            'CRM',
            'Payment Received for Manufactruing Date',
            'Crm Confirmation Date',
            'Customer Name',
            'Address Details',
            'Specifications',

            'Car Bracket',
            'Car Bracket Readiness Status',
            'Car Bracket Radiness Date',
            'Cwt Bracket',
            'Cwt Bracket Radiness Status',
            'Cwt Bracket Radiness Date',
            'LD Opening',
            'LD Finish',
            'LD Frame Status',
            'LD Frame Readiness Date',
            'LD Status',
            'LD Radiness Date',
            'Comments',

            'Machine Channel Type',
            'Machine Channel Readiness Status',
            'Machine channel Radiness Date',
            'Machine',
            'Machine Radiness Status',
            'Machine Radiness Date',
            'Car Frame',
            'Car Frame Readiness Status',
            'Car Frame Radiness Date',
            'Cwt Frame',
            'Cwt Frame Radiness Status',
            'Cwt Frame Radiness Date',
            'Rope Available',
            'OSG Assy Available',
            'Comments',

            'Cabin',
            'Cabin Readiness Status',
            'Cabin Radiness Date',
            'Controller',
            'Controller Readiness Status',
            'Controller Radiness Date',
            'Car Door Opening',
            'Car Door Finish',
            'Car Door Status',
            'Car Door Radiness Date',
            'COP & LOP',
            'COP & LOP Status',
            'COP & LOP Radiness Date',
            'Harness',
            'Harness Readiness Status',
            'Harness Radiness Date',
            'Comments',

            'Full Dispatched',
            'Full Dispatched Date',
            'Car Bracket Available Status',
            'Car Bracket Available Date',
            'Car Bracket Dispatch Status',
            'Car Bracket Dispatch Date',
            'Cwt Bracket Available Status',
            'Cwt Bracket Available Date',
            'Cwt Bracket Dispatch Status',
            'Cwt Bracket Dispatch Date',
            'LD Frame Received Date',
            'LD Frame Dispatch Status',
            'LD Frame Dispatch Date',
            'LD Received Date',
            'LD Dispatch Status',
            'LD Dispatch Date',

            'Full Dispatched',
            'Full Dispatched Date',
            'Machine Channel Received Date',
            'Machine Channel Dispatch Status',
            'Machine Channel Dispatch Date',
            'Machine Available Date',
            'Machine Dispatch Status',
            'Machine Dispatch Date',
            'Car Frame Received Date',
            'Car Frame Dispatch Status',
            'Car Frame Dispatch Date',
            'Cwt Frame Received Date:',
            'Cwt Frame Dispatch Status',
            'Cwt Frame Dispatch Date',
            'Rope Available Date',
            'Rope Dispatch Status',
            'Rope Dispatch Date',
            'OSG Assy Available Date',
            'OSG Assy Dispatch Status',
            'OSG Assy Dispatch Date',

            'Full Dispatched',
            'Full Dispatched Date',
            'Cabin Received Date',
            'Cabin Dispatch Status',
            'Cabin Dispatch Date',
            'Controller Available Date',
            'Controller Dispatch Status',
            'Controller Dispatch Date',
            'Car Door Received Date',
            'Car Door Dispatch Status',
            'Car Door Dispatch Date',
            'Cop And Lop Received Date',
            'Cop And Lop Dispatch Status',
            'Cop And Lop Dispatch Date',
            'Harness Available Date',
            'Harness Dispatch Status',
            'Harness Dispatch Date',
        ];
    }
}