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
class partDetails extends Model
{
    use SoftDeletes;

    public $table = 'parts_details';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'part_id',
        'description',
        'price',
        'gst',
        'is_deleted'
    ];


}
