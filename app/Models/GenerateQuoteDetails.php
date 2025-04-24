<?php

namespace App\Models;

use Eloquent as Model;
use App\Models\customers;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class plans
 * @package App\Models
 * @version June 30, 2021, 4:59 am UTC
 *
 * @property string title
 * @property string description
 */
class GenerateQuoteDetails extends Model
{
    use SoftDeletes;

    public $table = 'generate_quotes_details';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'quote_id',
        'plan',
        'price',
        'start_date',
        'is_deleted',
        'end_date',
        'payment_type',
        'status',
        'payment_date',
        'final_amount',
        'payment_id',
        'unique_job_number',
        'amc_status',
        'customer_id',
        'service'
    ];


    public function generateQuoteDetails()
    {
        return $this->hasOne('App\Models\GenerateQuote','id','quote_id');
    }


    public function getPlan(){
        return $this->hasOne('App\Models\plans','id','plan');
    }

}
