<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferenceSriLankanTeaProduction extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reference_srilankan_tea_production')->insert([
            [  'name'=>'High',
                'code'=>'HIGH',
                'type'=>'VALUES'  
            ],
            [  'name'=>'Medium',
                'code'=>'MEDIUM',
                'type'=>'VALUES'  
            ],
            [  'name'=>'Low',
                'code'=>'LOW',
                'type'=>'VALUES'  
            ],
            [  'name'=>'Green',
                'code'=>'GREEN',
                'type'=>'VALUES'  
            ],
            [  'name'=>'T/B Adjustment',
                'code'=>'TB_ADJUSTMENT',
                'type'=>'VALUES'  
            ],
            [  'name'=>'Total',
                'code'=>'TOTAL',
                'type'=>'TOTAL'  
            ],

        ]);
    }
}
