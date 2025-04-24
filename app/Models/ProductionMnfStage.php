<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionMnfStage extends Model
{

    public $table = 'production_mnf_stages';

    public $fillable = [
        'prod_id',
        'ms_id',
        'production_date',
        'readiness_date',
        'status',
        'mf_by',
    ];

}
