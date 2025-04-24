<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufactureCopLop extends Model
{
    use HasFactory;

    protected $fillable = [
        'manufactures_id',
        'cop_lop',
        'cop_lop_readiness_status',
        'cop_lop_readiness_date'
    ];

    // Define the relationship to the Manufacture model
    public function manufacture()
    {
        return $this->belongsTo(Manufacture::class, 'manufactures_id');
    }
}
