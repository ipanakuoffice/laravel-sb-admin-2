<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date_of_birth',
        'height',
        'weight',
        'gender',
        'installation',
        'daily_dose',
        'monthly_dose',
        'examination_type',
        'image_path',
    ];
}
