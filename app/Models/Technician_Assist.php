<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Technician_Assist
 * @package App\Models
 * @version September 30, 2021, 5:40 am UTC
 *
 * @property string $title
 * @property string $PDF
 */
class Technician_Assist extends Model
{
    use SoftDeletes;

    public $table = 'technician_assist';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'PDF',
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
        'PDF' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'PDF' => 'required'
    ];

    
}
