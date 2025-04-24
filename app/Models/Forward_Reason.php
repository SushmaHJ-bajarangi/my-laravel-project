<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Forward_Reason
 * @package App\Models
 * @version July 31, 2021, 9:55 am UTC
 *
 * @property string title
 */
class Forward_Reason extends Model
{
    use SoftDeletes;

    public $table = 'forward__reasons';
    

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
