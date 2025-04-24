<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class plans
 * @package App\Models
 * @version June 30, 2021, 4:59 am UTC
 *
 * @property string title
 * @property string description
 */
class GenerateQuote extends Model
{
    use SoftDeletes;

    public $table = 'generate_quotes';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'customer_id',
        'customer_job_id',
        'status',
        'is_deleted'
    ];


    public function generateQuoteDetails()
    {
        return $this->hasMany('App\Models\GenerateQuoteDetails','quote_id','id');
    }
    public function generateCustomer()
    {
        return $this->belongsTo('App\Models\customers','customer_id','id');
    }

    public function getGenerateQuoteDetails()
    {
        return $this->hasMany('App\Models\GenerateQuoteDetails','quote_id','id')->where('price','!=','')->where('is_deleted',0);
    }




}
