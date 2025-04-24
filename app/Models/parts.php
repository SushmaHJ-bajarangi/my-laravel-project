<?php

namespace App\Models;
use App\Models\partDetails;


use Eloquent as Model;
use http\Env\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class parts
 * @package App\Models
 * @version June 29, 2021, 12:45 pm UTC
 *
 * @property string title
 */
class parts extends Model
{
    use SoftDeletes;

    public $table = 'parts';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'title'
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


    public function helpers()
    {
        return $this->hasMany('App\Models\partDetails','description','price');
    }
}
