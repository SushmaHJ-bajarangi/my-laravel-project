<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class customers
 * @package App\Models
 * @version June 28, 2021, 10:29 am UTC
 *
 * @property string name
 * @property string email
 * @property string password
 * @property string authorized_person_name
 * @property string contact_number
 */
class SubscriptionHistory extends Model
{
    use SoftDeletes;

    public $table = 'subscription_history';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'plan',
        'unique_job_number',
        'customer_id',
        'amt',
        'is_deleted',
        'payment_method',
        'transaction_id',
        'start_date',
        'end_date',
    ];

}
