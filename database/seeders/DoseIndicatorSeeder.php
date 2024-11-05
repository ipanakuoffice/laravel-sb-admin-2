<?php

namespace Database\Seeders;

use App\Models\DoseIndicators;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoseIndicatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $doseIndicators = [
            ['dose_indicator_name' => 'Dosis RU'],
            ['dose_indicator_name' => 'Dosis denta'],
            ['dose_indicator_name' => 'Dosis Ctdi vol'],
            ['dose_indicator_name' => 'Dosis fluoro DAP/KAP'],
            ['dose_indicator_name' => 'Dosis Mamo'],
        ];

        foreach ($doseIndicators as $doseIndicatorData) {
            DoseIndicators::create($doseIndicatorData);
        }
    }
}
