<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExaminationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('examinations')->insert([
            [
                'patient_id' => 1,
                'modalitas_id' => 1,
                'dose_indicator_id' => 1,
                'tegangan' => '120',
                'dosis' => '5',
                'result' => 'Normal',
                'note' => 'No issues detected.',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 2,
                'modalitas_id' => 2,
                'dose_indicator_id' => 2,
                'tegangan' => '100',
                'dosis' => '4',
                'result' => 'Anomaly detected',
                'note' => 'Further tests recommended.',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
