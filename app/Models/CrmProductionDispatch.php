<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmProductionDispatch extends Model
{
    public $table = 'crmproductions_dispatch';

    public $fillable = [
        'crmproductions_id',
        'dispatch_stage_lots_status_id',
        'plandispatch_date',
        'dispatch_status_id',
        'go_down_dispatch_completion_date',
    ];

    public function crmproduction()
    {
        return $this->belongsTo(CrmProduction::class, 'crmproductions_id');
    }

    public function dispatchStatus()
    {
        return $this->belongsTo(DispatchStatus::class, 'dispatch_status_id');
    }

    public function dispatchStageLotStatus()
    {
        return $this->belongsTo(DispatchStageLotStatus::class, 'dispatch_stage_lots_status_id');
    }
}
