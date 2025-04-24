<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BackupTeam
 * @package App\Models
 * @version November 29, 2021, 3:03 pm IST
 *
 * @property string $name
 */
class Punches extends Model
{
    use SoftDeletes;

    public $table = 'punches';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'ticket_id',
        'technician_id',
        'type',
        'latitude',
        'longitude',
        'date',
        'time',
        'distance',
    ];

    public function getTechnician(){
        return $this->hasOne(team::class,'id','technician_id');
    }
}
