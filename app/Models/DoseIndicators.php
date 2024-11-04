<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoseIndicators extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'dose_indicator_name'
    ];

    public function examinations()
    {
        return $this->hasMany(Examinations::class);
    }
}
