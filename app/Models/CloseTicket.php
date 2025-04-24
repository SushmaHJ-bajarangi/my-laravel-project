<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CloseTicket
 * @package App\Models
 * @version September 21, 2021, 11:37 am UTC
 *
 * @property string $title
 */
class CloseTicket extends Model
{
    use SoftDeletes;

    public $table = 'close_tickets';
    

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
