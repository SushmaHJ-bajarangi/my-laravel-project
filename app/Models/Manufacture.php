<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacture extends Model
{
    use HasFactory;

    public $table = 'manufacturing';

    public $fillable = [
        'place',
        'jobs',
        'customer_name',
        'controller',
        'controller_readiness_status',
        'controller_readiness_date',
        'comments',
        'specification',
        'issue',
        'address',
    ];
}
