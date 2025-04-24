<?php

namespace App\Exports;

use App\Models\CrmProduction;
use App\Models\CrmProductionDispatch;
use App\Models\Crm;
use App\Models\customers;
use App\Models\StageOfMaterial;
use App\Models\Priority;
use App\Models\DispatchPaymentStatus;
use App\Models\ManufactureStatus;
use App\Models\ManufactureStage;
use App\Models\DispatchStageLotStatus;
use App\Models\DispatchStatus;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CrmProductionExport implements FromCollection,WithHeadings
{

    public function collection()
    {
        $crmProductions = CrmProduction::all();

        return $crmProductions->map(function ($crmProduction, $index) {

            $relatedCrm = Crm::find($crmProduction->crm_id);
            $relatedCustomer = customers::find($crmProduction->customer_id);
            $relatedStageOfMaterials = StageOfMaterial::find($crmProduction->stage_of_materials_id);
            $relatedPriority = Priority::find( $crmProduction->priority_id);
            $relatedDispatchPaymentsStatus = DispatchPaymentStatus::find( $crmProduction->dispatch_payments_status_id );
            $relatedManufactureStatus = ManufactureStatus :: find( $crmProduction->manufacture_status_id );
            $relatedManufactureStage = ManufactureStage :: find(  $crmProduction->manufacture_stages_id );
            $relatedDispatch = CrmProductionDispatch::where('crmproductions_id', $crmProduction->id)->latest('id')->first();
            $relatedDispatchStageLotStatus = DispatchStageLotStatus::find($relatedDispatch ? $relatedDispatch->dispatch_stage_lots_status_id : null);
            $relatedDispatchStatus = DispatchStatus::find( $relatedDispatch ? $relatedDispatch->dispatch_status_id : null);

            return [
                $index + 1,
                $relatedCrm ? $relatedCrm->name : null,
                $crmProduction->payment_received_manufacturing_date,
                $crmProduction->crm_confirmation_date,
                $crmProduction->job_no,
                $relatedCustomer ? $relatedCustomer->name : null,
                $crmProduction->addressu,
                $crmProduction->contract_value,
                $relatedStageOfMaterials ? $relatedStageOfMaterials->title : null,
                $relatedPriority ? $relatedPriority ->title : null,
                $crmProduction->requested_date_for_start_of_manufacturing_from_teknix_office,
                $crmProduction->dispatch_request_date_from_teknix_office,
                $relatedDispatchPaymentsStatus ? $relatedDispatchPaymentsStatus->Name : null,
                $crmProduction->amount_pending_for_dispatch,
                $crmProduction->dispatch_comment,

                $crmProduction->specifications,
                $relatedManufactureStatus ? $relatedManufactureStatus -> title : null,
                $relatedManufactureStage ? $relatedManufactureStage -> title :null,
                $crmProduction->manufacture_completion_date,
                $crmProduction->is_revised,
                $crmProduction->factory_commitment_date,
                $crmProduction->manufacture_comment,

                $crmProduction->material_received_date_from_factory,
                $crmProduction->no_of_days_since_ready_for_dispatch,

                $relatedDispatchStageLotStatus ? $relatedDispatchStageLotStatus->Name : null,
                $relatedDispatch ? $relatedDispatch->plandispatch_date : null,
                $relatedDispatchStatus ? $relatedDispatchStatus->title : null,
                $relatedDispatch ? $relatedDispatch->go_down_dispatch_completion_date : null,

                $crmProduction->comments,
            ];
        });
    }

    public function headings():array
    {
        return [
            '#',
            'CRM',
            'Payment Received for Manufacturing Date',
            'Crm Confirmation Date',
            'Job No',
            'Customer Name',
            'Address Details',
            'Contract Value',
            'Request for Production',
            'Standard / Non standard',
            'Requested Date for Start of Manufacturing from Teknix Office',
            'Dispatch Request Date from Teknix Office',
            'Dispatch Payment Status',
            'Amount Pending for Dispatch in INR',
            'Comments',

            'Specifications',
            'Manufacturing Status',
            'Manufacturing -Stage / Lot',
            'Manufacture Completion Date',
            'Is Revised',
            'Factory Commitment Date',
            'Manufacture Comment',

            'Material Received Date From Factory',
            'No of days since ready for dispatch',

            'Dispatch - Stage / Lot',
            'Plan dispatch date',
            'Dispatch Status',
            'Go Down: Dispatch Completion Date',

            'comments',
        ];
    }
}

