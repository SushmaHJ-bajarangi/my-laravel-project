<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Zone
 * @package App\Models
 * @version September 29, 2021, 9:41 am UTC
 *
 * @property string $description
 */
class Zone extends Model
{
    use SoftDeletes;

    public $table = 'zones';
    

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
