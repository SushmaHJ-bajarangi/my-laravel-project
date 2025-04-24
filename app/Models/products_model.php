<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class products_model
 * @package App\Models
 * @version June 30, 2021, 7:17 am UTC
 *
 * @property string title
 */
class products_model extends Model
{
    use SoftDeletes;

    public $table = 'products_models';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'is_deleted'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required'
    ];

    
}
