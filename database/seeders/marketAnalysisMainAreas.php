<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class marketAnalysisMainAreas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('market_analysis_main_areas')->insert([
            [
                'name' => 'High Grown Tea',
                'code' => 'HIGH_GROWN',
            ],
            [
                'name' => 'Medium Grown Tea',
                'code' => 'MEDIUM_GROWN',
            ],
            [
                'name' => 'Unorthodox/CTC Tea',
                'code' => 'UNORTHODOX',
            ],
            [
                'name' => 'Off Grades',
                'code' => 'OFF_GRADES',
            ],
            [
                'name' => 'Dusts',
                'code' => 'DUSTS',
            ],
            [
                'name' => 'Low Grown Tea',
                'code' => 'LOW_GROWN',
            ]
        ]);
    }
}
