<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class activity extends Model
{
    public $table = 'activity';

    public $fillable = [
        't_name',
        'change_by',
        'activity',
    ];

}