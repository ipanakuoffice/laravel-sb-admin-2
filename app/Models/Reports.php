<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'daily_dose',
        'monthly_dose',
        'examination_type',
        'image_path',
    ];
}
