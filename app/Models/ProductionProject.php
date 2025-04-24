<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionProject extends Model
{
    public $table = 'production_projects';

    public $fillable = [
        'job_no',
        'customer_name',
        'project_name',
        'crm_id',
        'payment_received_manufacturing_date',
        'crm_confirmation_date',
        'address',
        'specifications'
    ];
}