<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\customers;
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
class PartsRequest extends Model
{
    use SoftDeletes;

    public $table = 'parts_request';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'unique_job_number',
        'customer_id',
        'amt',
        'technician_user_id',
        'parts_id',
        'quantity',
        'final_price',
        'payment_method',
        'payment_id',
        'ticket_id',
        'is_deleted',
        'payment_type',
        'date',
        'status',
        'admin_status',
        'payment_date'
    ];
    public function getCustomer(){
        return $this->hasOne('App\Models\customers','id','customer_id');
    }
    public function getTeam(){
        return $this->hasOne('App\Models\team','id','technician_user_id');
    }
}
