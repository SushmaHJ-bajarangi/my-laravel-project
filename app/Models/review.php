<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Doors
 * @package App\Models
 * @version July 27, 2021, 12:33 pm UTC
 *
 * @property string title
 */
class review extends Model
{

    public $table = 'review';


    public $fillable = [
        'id',
        't_rating',
        'c_rating',
        't_star',
        'c_star',
        'rating_for',
        'ticket_id',
        'comment_tec',
        'comment_cus',

    ];
    protected $casts = [
        'id' => 'integer',
        't_rating' => 'string',
        'c_rating' => 'string',
        't_star' => 'string',
        'c_star' => 'string',
        'rating_for' => 'string',
        'ticket_id' => 'string',
        'comment_tec' => 'string',
        'comment_cus' => 'string',
    ];

}
