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
class plans extends Model
{
    use SoftDeletes;

    public $table = 'plans';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'description',
        'duration',
        'is_deleted'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'description' => 'required',
        'duration' => 'required',
    ];

    
}
