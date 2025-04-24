<?php

namespace App\Models;

use Eloquent as Model;

class app_version extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table='version';
    protected $fillable = [
        'version','url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
}
