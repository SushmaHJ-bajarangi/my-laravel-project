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
 * @property string $name
 * @property string $email
 * @property string $number
 * @property string $zone
 */
class BackupTeam extends Model
{
    use SoftDeletes;

    public $table = 'backup_teams';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'name',
        'email',
        'contact_number',
        'zone'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'name' => 'string',
        'email' => 'string',
        'contact_number' => 'string',
        'zone' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'name' => 'required',
        'email' => 'required',
        'contact_number' => 'required',
        'zone' => 'required'
    ];

    
}
