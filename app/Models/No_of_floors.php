<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class No_of_floors
 * @package App\Models
 * @version July 27, 2021, 12:36 pm UTC
 *
 * @property string title
 */
class No_of_floors extends Model
{
    use SoftDeletes;

    public $table = 'no_of_floors';
    

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
