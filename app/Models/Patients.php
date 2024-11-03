<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patients extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'date_of_birth',
        'height',
        'weight',
        'gender',
        'modalitas',
    ];

    public function doseIndicators()
    {
        return $this->belongsToMany(doseIndicators::class, 'dose_indicator_patient');
    }
}
