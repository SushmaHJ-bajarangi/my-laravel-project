<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class servicenote extends Model
{
    use SoftDeletes;

    public $table = 'servicenote';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'service_id',
        'description',
        'is_deleted'
            ];

}
