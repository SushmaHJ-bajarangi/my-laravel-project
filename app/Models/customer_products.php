<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class customer_products
 * @package App\Models
 * @version June 30, 2021, 7:51 am UTC
 *
 * @property string customer_id
 * @property string model_id
 * @property string door
 * @property string number_of_floors
 * @property string cop_type
 * @property string lop_type
 * @property string passenger_capacity
 * @property string distance
 * @property string unique_job_number
 * @property string warranty_start_date
 * @property string warranty_end_date
 */
class customer_products extends Model
{
    use SoftDeletes;

    public $table = 'customer_products';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'customer_id',
        'area',
        'noofstops',
        'model_id',
        'number_of_floors',
        'passenger_capacity',
        'distance',
        'unique_job_number',
        'warranty_start_date',
        'warranty_end_date',
        'ordered_date',
        'status',
        'is_deleted',
        'no_of_services',
        'address',
        'zone',
        'amc_start_date',
        'amc_end_date',
        'amc_status',
        'side_status',
//       'amc_value',
        'project_name',
        'latitude',
        'longitude'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'customer_id' => 'string',

        'area'=> 'string',
        'noofstops'=> 'integer',

        'model_id' => 'string',
        'number_of_floors' => 'string',
        'passenger_capacity' => 'string',
        'distance' => 'string',
        'unique_job_number' => 'string',
        'warranty_start_date' => 'string',
        'warranty_end_date' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'customer_id' => 'required',
        'model_id' => 'required',
        'number_of_floors' => 'required',
        'passenger_capacity' => 'required',
        'distance' => 'required',
        'unique_job_number' => 'required'
    ];

    public function getCustomer(){
        return $this->hasOne('App\Models\customers','id','customer_id');
    }
    public function getModel(){
        return $this->hasOne('App\Models\products_model','id','model_id');
    }

}
