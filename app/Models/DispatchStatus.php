<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BackupTeam
 * @package App\Models
 * @version November 29, 2021, 3:03 pm IST
 *
 * @property string $title
 */
class DispatchStatus extends Model
{
    use SoftDeletes;

    public $table = 'dispatch_status';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
    ];


}
