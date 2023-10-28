<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class referenceOverallMarket extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reference_overall_market')->insert([
            [
                'name' => 'Ex Estate',
                'code' => 'EXES',
            ],
            [
                'name' => 'High and Medium',
                'code' => 'HIGHMD',
            ],
            [
                'name' => 'Leafy',
                'code' => 'LF',
            ],
            [
                'name' => 'Semi Leafy',
                'code' => 'SLF',
            ],
            [
                'name' => 'Tippy/Small Leafy',
                'code' => 'TSL',
            ],
            [
                'name' => 'Premium Flowery',
                'code' => 'PF',
            ],
            [
                'name' => 'Off Grade',
                'code' => 'OG',
            ],
            [
                'name' => 'BOP1A',
                'code' => 'BOP1A',
            ],
            [
                'name' => 'Dust',
                'code' => 'DUST',
            ],
            [
                'name' => 'Total',
                'code' => 'TOTAL',
            ],
        ]);
    }
}
