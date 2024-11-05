<?php

namespace Database\Seeders;

use App\Models\Modalitas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModalitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $modalitas = [
            ['modalitas_name' => 'Radiografi umum'],
            ['modalitas_name' => 'Fluoroskopi'],
            ['modalitas_name' => 'Dental intraoral'],
            ['modalitas_name' => 'Cephalo'],
            ['modalitas_name' => 'Mamografi'],
            ['modalitas_name' => 'CT scan'],
        ];

        foreach ($modalitas as $modalitasData) {
            Modalitas::create($modalitasData);
        }
    }
}
