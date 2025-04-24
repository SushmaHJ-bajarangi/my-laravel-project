<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class team
 * @package App\Models
 * @version June 28, 2021, 12:36 pm UTC
 *
 * @property string title
 * @property string name
 * @property string email
 * @property string password
 * @property string contact_number
 */
class team extends Model
{
    use SoftDeletes;

    public $table = 'teams';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'name',
        'email',
        'contact_number',
        'is_deleted',
        'zone',
        'device_token'
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
        'contact_number' => 'string'
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
        'contact_number' => 'required'
    ];
    
    public function helpers()
    {
        return $this->hasMany('App\Models\Helpers');
    }
}
