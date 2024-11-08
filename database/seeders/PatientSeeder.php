<?php

namespace Database\Seeders;

use App\Models\Patients;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Patients::create([
            'name' => 'John Doe',
            'date_of_birth' => '1985-08-15',
            'height' => 180,
            'weight' => 75,
            'gender' => 'Male',
            'nip' => Patients::generateUniqueNip(),
        ]);

        Patients::create([
            'name' => 'Jane Smith',
            'date_of_birth' => '1990-02-20',
            'height' => 165,
            'weight' => 60,
            'gender' => 'Female',
            'nip' => Patients::generateUniqueNip(),
        ]);
    }
}
