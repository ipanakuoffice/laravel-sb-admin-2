<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modalitas extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'modalitas_name'
    ];

    public function examinations()
    {
        return $this->hasMany(Examinations::class);
    }
}
