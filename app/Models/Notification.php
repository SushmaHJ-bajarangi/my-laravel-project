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
class Notification extends Model
{
    use SoftDeletes;

    public $table = 'notifications';

    public $fillable = [
        'message',
        'to_user_id',
        'is_important',
        'job_number',
        'type',
        'sent_at',
        'is_read'
    ];


}
