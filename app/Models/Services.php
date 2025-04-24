<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class plans
 * @package App\Models
 * @version June 30, 2021, 4:59 am UTC
 *
 * @property string title
 * @property string description
 */
class Services extends Model
{
    use SoftDeletes;

    public $table = 'services';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'customer_id',
        'unique_job_number',
        'customer_product_id',
        'date',
        'status',
        'image',
        'technician_id',
        'assign_team_id',
        'zone',
        'is_deleted',
        'service_type',
        'signature_image',
        'authname',
        'auth_number',
        'service_list',
        'tech_name'
    ];

    public function getTeam(){
        return $this->hasOne('App\Models\team','id','assign_team_id');
    }
    public function getCustomer(){
        return $this->hasOne('App\Models\customers','id','customer_id');
    }

}
