<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmProduction extends Model
{
    public $table = 'crmproductions';

    public $fillable = [
        'crm_id',
        'payment_received_manufacturing_date',
        'crm_confirmation_date',
        'job_no',
        'customer_id',
        'addressu',
        'contract_value',
        'stage_of_materials_id',
        'priority_id',
        'requested_date_for_start_of_manufacturing_from_teknix_office',
        'dispatch_request_date_from_teknix_office',
        'dispatch_payments_status_id',
        'amount_pending_for_dispatch',
        'dispatch_comment',
        'specifications',
        'factory_commitment_date',
        'is_revised',
        'manufacture_status_id',
        'manufacture_stages_id',
        'manufacture_completion_date',
        'manufacture_comment',
        'material_received_date_from_factory',
        'no_of_days_since_ready_for_dispatch',
        'comments',
        'created_from_crm'
    ];

    public function getDispatchStatusData()
    {
        return $this->belongsTo(CrmProductionDispatch::class, 'id','crmproductions_id');
    }
    
}
