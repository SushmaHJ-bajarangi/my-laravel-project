<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionSom extends Model
{

    public $table = 'production_som';

    public $fillable = [
        'prod_id',
        'som_id',
        'note',
    ];



}
