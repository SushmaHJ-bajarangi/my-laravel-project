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

class PlanPrice extends Model

{

    use SoftDeletes;



    public $table = 'plan_price';





    protected $dates = ['deleted_at'];





    public $fillable = [

        'plan_id',

        'price',

        'no_of_floors_from',

        'no_of_floors_to',

        'passengers_capacity_from',

        'passengers_capacity_to',

        'is_deleted',

    ];



    public function getPlan(){

        return $this->hasOne('App\Models\plans','id','plan_id');

    }

}