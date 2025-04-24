<?php

namespace App\Exports;

use App\Models\Production;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ManufactureProductionExport implements FromCollection,WithHeadings
{
    public function collection()
    {
        return Production::all();
    }

    public function headings():array
    {
        return [
            '#',
            'manager',
            'mnf_payment_date',
            'crm_confirmation_date',
            'job_no',
            'customer_id',
            'contract_value',
            'priority',
            'mnf_confirmation_date',
            'original_planned_dispatch_date',
            'revised_planned_dispatch_date',
            'dispatch_payment_status',
            'pending_dispatch_amount_inr',
            'manufacturing_status',
            'dispatch_status',
            'comments',
            'comments',
            'factory_commitment_date',
            'revised_date_reason',
            'revised_planed_dispatch',
            'dispatch_date_reason_factory',
            'revised_commitment_date_factory',
            'material_readiness',
            'completion_status',
            'no_of_days',
            'dispatch_date',
            'specification',
            'issue',
            'address',
        ];
    }
}