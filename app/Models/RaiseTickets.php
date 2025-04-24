<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\customers;
/**
 * Class team
 * @package App\Models
 * @version June 28, 2021, 12:36 pm UTC
 *
 * @property string title
 * @property string name
 * @property string email
 * @property string password
 * @property string contact_number
 */
class RaiseTickets extends Model
{
    use SoftDeletes;

    public $table = 'raise_tickets';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'description',
        'image',
        'signature_image',
        'status',
        'hold_reason',
        'forward_reason',
        'assigned_to',
        'customer_id',
        'product_id',
        'unique_job_number',
        'date',
        'progress_date',
        'complete_date',
        'parts',
        'is_deleted',
        'ic_canceled',
        'is_urgent',
        'customer_status',
        'title_close',
        'close_description',
        'close_image',
        'authname',
        'auth_number'
    ];

    public function getCustomer(){
        return $this->hasOne('App\Models\customers','id','customer_id');
    }

    public function getechnicianName(){
        return $this->hasOne('App\Models\team','id','assigned_to');
    }
}
