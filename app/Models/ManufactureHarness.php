<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufactureHarness extends Model
{
    use HasFactory;

    protected $fillable = [
        'manufactures_id',
        'harness',
        'harness_readiness_status',
        'harness_readiness_date'
    ];

    // Define the relationship to the Manufacture model
    public function manufacture()
    {
        return $this->belongsTo(Manufacture::class, 'manufactures_id');
    }
}

