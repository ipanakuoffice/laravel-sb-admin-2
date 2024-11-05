<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Examinations extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'modalitas_id',
        'dose_indicator_id',
        'tegangan',
        'dosis',
        'result',
        'note',
        'created_by'
    ];

    public function patient()
    {
        return $this->belongsTo(Patients::class);
    }

    public function modalitas()
    {
        return $this->belongsTo(Modalitas::class);
    }

    public function doseIndicator()
    {
        return $this->belongsTo(DoseIndicators::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
