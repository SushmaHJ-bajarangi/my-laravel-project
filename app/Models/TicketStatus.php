<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class customers
 * @package App\Models
 * @version June 28, 2021, 10:29 am UTC
 *
 * @property string name
 * @property string email
 * @property string password
 * @property string authorized_person_name
 * @property string contact_number
 */
class TicketStatus extends Model
{
    use SoftDeletes;

    public $table = 'ticket_status';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'technician_id',
        'ticket_id',
        'status',
        'reason',
        'date',
    ];

    public function getTechnician(){
        return $this->hasOne(team::class,'id','technician_id');
    }
}
