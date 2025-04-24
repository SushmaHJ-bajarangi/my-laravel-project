<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class parts
 * @package App\Models
 * @version June 29, 2021, 12:45 pm UTC
 *
 * @property string title
 */
class parts_purchase extends Model
{
    use SoftDeletes;

    public $table = 'parts_purchase';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'parts_id',
        'price',
        'final_price',
        'is_deleted',
        'unique_job_number',
        'is_deleted'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'parts_id' => 'string',
        'price' => 'string',
        'unique_job_numer' => 'string',
        'final_price' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'final_price' => 'required',
        'parts_id' => 'required',
        'price' => 'required',
        'unique_job_numer' => 'required'
    ];


}