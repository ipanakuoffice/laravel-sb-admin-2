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
        'nip'
    ];

    public function examinations()
    {
        return $this->hasMany(Examinations::class);
    }

    public static function generateUniqueNip()
    {
        do {
            $year = date('y'); // 2 digit tahun, misalnya 24
            $month = date('m'); // 2 digit bulan, misalnya 11
            $time = date('His'); // Waktu dalam format HHMMSS, misalnya 103045

            $unique = strtoupper(substr(uniqid(), -2)); // 2 karakter unik dari uniqid

            // Format NIP dengan P-tahunbulanwaktuuniqid
            $nip = 'P-' . $year . $month . $time . $unique;
        } while (self::where('nip', $nip)->exists());

        return $nip;
    }
}
