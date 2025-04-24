<?php

namespace App\Imports;

use App\Models\Production;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductionRequestImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            Production::create([
                'name' => $row[0],
                'manager' => $row[1],
                'mnf_payment_date'=> $row[2],
                'crm_confirmation_date'=> $row[3],
                'job_no'=> $row[4],
                'customer_id'=> $row[5],
                'contract_value'=> $row[6],
                'priority'=> $row[7],
                'mnf_confirmation_date'=> $row[8],
                'original_planned_dispatch_date'=> $row[9],
                'revised_planned_dispatch_date'=> $row[10],
                'dispatch_payment_status'=> $row[11],
                'pending_dispatch_amount_inr'=> $row[12],
                'manufacturing_status'=> $row[13],
                'dispatch_status'=> $row[14],
                'comments'=> $row[15],
                'factory_commitment_date'=> $row[16],
                'revised_date_reason'=> $row[17],
                'revised_planed_dispatch'=> $row[18],
                'dispatch_date_reason_factory'=> $row[19],
                'revised_commitment_date_factory'=> $row[20],
                'material_readiness'=> $row[21],
                'completion_status'=> $row[22],
                'no_of_days'=> $row[23],
                'dispatch_date'=> $row[24],
                'specification'=> $row[25],
                'issue'=> $row[26],
                'address'=> $row[27],
            ]);
        }
    }
}