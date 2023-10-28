<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefWorldTeaProduction extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reference_world_tea_production')->insert([
            [
                'name' => 'Sri Lanka',
                'code'=>'SL',
                'type'=>'LAST_MONTH'
            ],
            [
                'name' => 'Bangladesh',
                'code'=>'BNG',
                'type'=>'ONE_TO_LAST'
            ],
            [
                'name' => 'North India',
                'code'=>'NI',
                'type'=>'ONE_TO_LAST'
            ],
            [
                'name' => 'South India',
                'code'=>'SI',
                'type'=>'ONE_TO_LAST'
            ],
            [
                'name' => 'Malawi',
                'code'=>'ML',
                'type'=>'SECOND_TO_LAST'
            ],      
            [
                'name' => 'Kenya',
                'code'=>'KY',
                'type'=>'SECOND_TO_LAST'
            ], 
        ]);
    }
}
