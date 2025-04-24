<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfferCustomer extends Model
{
    use SoftDeletes;

    protected $table = 'offerCustomer';

    protected $fillable = [
        'offer_type',
        'offer_date',
        'offer_no',
        'site_name',
        'address',
        'is_deleted'
    ];

    protected $dates = ['deleted_at'];
}
