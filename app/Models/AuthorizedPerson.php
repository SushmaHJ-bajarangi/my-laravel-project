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
class AuthorizedPerson extends Model
{
    use SoftDeletes;

    public $table = 'authorized_person';


    protected $dates = ['deleted_at'];
    
    public $fillable = [
        'name',
        'contact_number',
        'customer_id',
        'unique_job_number',
        'is_deleted'
    ];


}
