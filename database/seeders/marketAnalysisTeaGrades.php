<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class marketAnalysisTeaGrades extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('market_analysis_tea_grades')->insert([
            [                
                'market_analysis_main_area_id' => '1',
                'tea_grade' => 'BOP'
            ],
            [                
                'market_analysis_main_area_id' => '1',
                'tea_grade' => 'BOPF'
            ],
            [
                'market_analysis_main_area_id' => '1',
                'tea_grade' => 'OP/OPA'
            ],
            [                
                'market_analysis_main_area_id' => '1',
                'tea_grade' => 'PEKOE/PEKOE1'
            ],
            [                
                'market_analysis_main_area_id' => '1',
                'tea_grade' => 'FBOP/FBOPF1'
            ],
            [                
                'market_analysis_main_area_id' => '2',
                'tea_grade' => 'BOP'
            ],
            [                
                'market_analysis_main_area_id' => '2',
                'tea_grade' => 'BOPF'
            ],
            [                
                'market_analysis_main_area_id' => '2',
                'tea_grade' => 'OP/OPA'
            ],
            [                
                'market_analysis_main_area_id' => '2',
                'tea_grade' => 'PEKOE/PEKOE1'
            ],
            [                
                'market_analysis_main_area_id' => '2',
                'tea_grade' => 'FBOP/FBOPF1'
            ],
            [                
                'market_analysis_main_area_id' => '3',
                'tea_grade' => 'High Grown'
            ],
            [                
                'market_analysis_main_area_id' => '3',
                'tea_grade' => 'Medium Grown'
            ],
            [                
                'market_analysis_main_area_id' => '3',
                'tea_grade' => 'Low Grown'
            ],
            [                
                'market_analysis_main_area_id' => '4',
                'tea_grade' => 'FGS1/FGS'
            ],
            [                
                'market_analysis_main_area_id' => '4',
                'tea_grade' => 'BROKENS'
            ],
            [                
                'market_analysis_main_area_id' => '4',
                'tea_grade' => 'BOP1A'
            ],
            [                
                'market_analysis_main_area_id' => '5',
                'tea_grade' => 'DUST 1'
            ],
            [                
                'market_analysis_main_area_id' => '5',
                'tea_grade' => 'DUST'
            ],
            [                
                'market_analysis_main_area_id' => '6',
                'tea_grade' => 'FBOP/FBOP1'
            ],
            [
                'market_analysis_main_area_id' => '6',
                'tea_grade' => 'BOP'
            ],
            [                
                'market_analysis_main_area_id' => '6',
                'tea_grade' => 'BOP1'
            ],
            [
                'market_analysis_main_area_id' => '6',
                'tea_grade' => 'OP1'
            ],
            [                
                'market_analysis_main_area_id' => '6',
                'tea_grade' => 'OP'
            ],
            [                
                'market_analysis_main_area_id' => '6',
                'tea_grade' => 'OPA'
            ],
            [                
                'market_analysis_main_area_id' => '6',
                'tea_grade' => 'PEKOE'
            ],
            [                
                'market_analysis_main_area_id' => '6',
                'tea_grade' => 'BOPF'
            ],
            [                
                'market_analysis_main_area_id' => '6',
                'tea_grade' => 'FBOPF/FBOPF1'
            ],

        ]);
    }
}
