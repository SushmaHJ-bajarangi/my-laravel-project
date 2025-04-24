<?php

namespace App\Imports;

use App\Models\CrmProduction;
use App\Models\CrmProductionDispatch;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Flash;

class CrmProductionImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row)
        {
            if($key == 0){
                continue;
            }

            $crmProduction = CrmProduction::create([
                'id' => $row[0],
                'crm_id'  => $row[1],
                'payment_received_manufacturing_date' => $row[2],
                'crm_confirmation_date' => $row[3],
                'job_no' => $row[4],
                'customer_id' => $row[5],
                'addressu' => $row[6],
                'contract_value' => $row[7],
                'stage_of_materials_id' => $row[8],
                'priority_id' => $row[9],
                'requested_date_for_start_of_manufacturing_from_teknix_office' => $row[10],
                'dispatch_request_date_from_teknix_office' => $row[11],
                'dispatch_payments_status_id' => $row[12],
                'amount_pending_for_dispatch' => $row[13],
                'dispatch_comment' => $row[14],
                'specifications' => $row[15],
                'factory_commitment_date' => $row[16],
                'is_revised' => $row[17],

                'manufacture_status_id' => $row[18],
                'manufacture_stages_id' => $row[19],
                'manufacture_completion_date' => $row[20],
                'manufacture_comment' => $row[21],
                'material_received_date_from_factory' => $row[22],

                'no_of_days_since_ready_for_dispatch' => $row[23],
                'comments' => $row[24],
                'created_from_crm' => $row[25],
                'created_at' => $row[26],
                'updated_at' => $row[27],
            ]);

            CrmProductionDispatch::create([
                'crmproductions_id' => $crmProduction->id,
                'dispatch_stage_lots_status_id'  => $row[28],
                'plandispatch_date' => $row[29],
                'dispatch_status_id' => $row[30],
                'go_down_dispatch_completion_date' => $row[31],
            ]);

        }
    }
}