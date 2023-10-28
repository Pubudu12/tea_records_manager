<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class refOverallElevationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        DB::table('reference_overall_elevations')->insert([
            [
                'name' => 'Ex Estate',
                'level' => '1',
                'code' => 'EXES',
                'parent_category' => '0',
                'order' => '1',
            ],
            [
                'name' => 'Best Western',
                'level' => '3',
                'code' => 'BW',
                'parent_category' => '1',
                'order' => '2',
            ],
            [
                'name' => 'Below Best Western',
                'level' => '3',
                'code' => 'BBW',
                'parent_category' => '1',
                'order' => '3',
            ],
            [
                'name' => 'Plainer Western',
                'level' => '3',
                'code' => 'PW',
                'parent_category' => '1',
                'order' => '4',
            ],
            [
                'name' => 'Nuwara Eliyas',
                'level' => '3',
                'code' => 'NE',
                'parent_category' => '1',
                'order' => '5',
            ],
            [
                'name' => 'Uda Pussellawa',
                'level' => '3',
                'code' => 'UP',
                'parent_category' => '1',
                'order' => '6',
            ],
            [
                'name' => 'Uva',
                'level' => '3',
                'code' => 'UVA',
                'parent_category' => '1',
                'order' => '7',
            ],
            [
                'name' => 'CTC',
                'level' => '2',
                'code' => 'CTC',
                'parent_category' => '1',
                'order' => '8',
            ],
            [
                'name' => 'High Grown',
                'level' => '3',
                'code' => 'HG',
                'parent_category' => '1',
                'order' => '9',
            ],
            [
                'name' => 'Medium Grown',
                'level' => '3',
                'code' => 'MG',
                'parent_category' => '1',
                'order' => '10',
            ],
            [
                'name' => 'Low Grown',
                'level' => '3',
                'code' => 'LG',
                'parent_category' => '1',
                'order' => '11',
            ],
            [
                'name' => 'Liquoring Leafy',
                'level' => '1',
                'code' => 'LL',
                'parent_category' => '0',
                'order' => '12',
            ],
            [
                'name' => 'High',
                'level' => '3',
                'code' => 'HIGH',
                'parent_category' => '12',
                'order' => '13',
            ],
            [
                'name' => 'Medium',
                'level' => '3',
                'code' => 'MEDIUM',
                'parent_category' => '12',
                'order' => '14',
            ],
            [
                'name' => 'Low Grown',
                'level' => '1',
                'code' => 'LG',
                'parent_category' => '0',
                'order' => '15',
            ],
            [
                'name' => 'Tippy',
                'level' => '2',
                'code' => 'TIPPY',
                'parent_category' => '15',
                'order' => '16',
            ],
            [
                'name' => 'FBOP',
                'level' => '3',
                'code' => 'FBOP',
                'parent_category' => '15',
                'order' => '17',
            ],
            [
                'name' => 'FF1',
                'level' => '3',
                'code' => 'FF1',
                'parent_category' => '15',
                'order' => '18',
            ],
            [
                'name' => 'Premium Flowery',
                'level' => '3',
                'code' => 'PF',
                'parent_category' => '15',
                'order' => '19',
            ],
            [
                'name' => 'Leafy',
                'level' => '2',
                'code' => 'LEAFY',
                'parent_category' => '15',
                'order' => '20',
            ],
            [
                'name' => 'BOP1/OP1',
                'level' => '3',
                'code' => 'BOP1/OP1',
                'parent_category' => '15',
                'order' => '21',
            ],
            [
                'name' => 'OP/OPA',
                'level' => '3',
                'code' => 'OP/OPA',
                'parent_category' => '15',
                'order' => '22',
            ],
            [
                'name' => 'PEK/PEK1',
                'level' => '3',
                'code' => 'PEK/PEK1',
                'parent_category' => '15',
                'order' => '23',
            ],
            [
                'name' => 'Off Grades',
                'level' => '1',
                'code' => 'OG',
                'parent_category' => '0',
                'order' => '24',
            ],
            [
                'name' => 'FGS/FGS1',
                'level' => '3',
                'code' => 'FGS/FGS1',
                'parent_category' => '24',
                'order' => '25',
            ],
            [
                'name' => 'Brokens',
                'level' => '3',
                'code' => 'BRKNS',
                'parent_category' => '24',
                'order' => '26',
            ],
            [
                'name' => 'Dust/Dust 1',
                'level' => '1',
                'code' => 'DD1',
                'parent_category' => '0',
                'order' => '27',
            ],
            [
                'name' => 'Primary',
                'level' => '3',
                'code' => 'PRIM',
                'parent_category' => '27',
                'order' => '28',
            ],
            [
                'name' => 'Secondary',
                'level' => '3',
                'code' => 'SC',
                'parent_category' => '27',
                'order' => '29',
            ],
        ]);
    }
}
