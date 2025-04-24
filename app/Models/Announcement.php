<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Announcement
 * @package App\Models
 * @version July 29, 2021, 5:07 am UTC
 *
 * @property string title
 * @property string description
 * @property string image
 */
class Announcement extends Model
{
    use SoftDeletes;

    public $table = 'announcements';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'technician',
        'title',
        'image',
        'date',
        'is_deleted',
        'description',

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'image' => 'string',
        'technician'=>'string',
        'date'=>'string',
        'title' => 'string',
        'description' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'technician'=>'required',
        'title' => 'required',
        'description' => 'required',
    ];

    
}
