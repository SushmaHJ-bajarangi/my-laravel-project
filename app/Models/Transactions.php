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
class Transactions extends Model
{
    use SoftDeletes;

    public $table = 'transactions';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'customer_id',
        'order_id',
        'tracking_id',
        'bank_ref_no',
        'order_status',
        'failure_message',
        'payment_mode',
        'card_name',
        'status_code',
        'currency',
        'amount',
        'billing_name',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_country',
        'billing_tel',
        'billing_email',
        'delivery_name',
        'delivery_address',
        'delivery_city',
        'delivery_state',
        'delivery_zip',
        'delivery_country',
        'delivery_tel',
        'vault',
        'offer_type',
        'offer_code',
        'discount_value',
        'mer_amount',
        'eci_value',
        'retry',
        'response_code',
        'billing_notes',
        'trans_date',
        'merchant_param1',
        'merchant_param2',
        'merchant_param3',
        'merchant_param4',
        'merchant_param5',
        'bin_country',
        'status_message',
        'transaction_for'
    ];

    public function getCustomer(){
        return $this->hasOne('App\Models\customers','id','customer_id');
    }


}
