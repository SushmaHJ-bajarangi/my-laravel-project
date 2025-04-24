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
class Settings extends Model
{
    use SoftDeletes;

    public $table = 'settings';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'key',
        'value',
        'is_deleted'
    ];
}