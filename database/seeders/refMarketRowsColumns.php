<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class refMarketRowsColumns extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reference_market_rows_columns')->insert([
            [
                'elevation_name' => 'High Grown Tea',
                'code'=>'HIGH_GROWN',
                'description_tea_grades' => '["BOP","BOPF","OP/OPA","PEKOE/PEKOE1","FBOP/FBOPF1"]',
                'table_columns' => '["BOP","BOPF","PEKOE/FBOP","OP"]',
                'table_rows' => '["Best Westerns","Below Best Westerns","Plainer Westerns","Nuwara Eliyas","Brighter Udapussellawas","Other Udapussellawas","Best Uvas","Other Uvas"]'
            ],
            [
                'elevation_name' => 'Medium Grown Tea',
                'code'=>'MEDIUM_GROWN',
                'description_tea_grades' => '["BOP","BOPF","OP/OPA","PEKOE/PEKOE1","FBOP/FBOPF1"]',
                'table_columns' => '["BOP","BOPF","PEKOE/FBOP","OP"]',
                'table_rows' => '["Good Mediums","Other Mediums"]'
            ],
            [
                'elevation_name' => 'High Grown Tea',
                'code'=>'HIGH_GROWN',
                'description_tea_grades' => '["BOP","BOPF","OP/OPA","PEKOE/PEKOE1","FBOP/FBOPF1"]',
                'table_columns' => '["BOP","BOPF","PEKOE/FBOP","OP"]',
                'table_rows' => '["Best Westerns","Below Best Westerns","Plainer Westerns","Nuwara Eliyas","Brighter Udapussellawas","Other Udapussellawas","Best Uvas","Other Uvas"]'
            ],
        ]);
    }
}
