<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class publicAuctionAreas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('public_auction_gross_sale_average_areas')->insert([
            [
                'name' => 'Uva High',
                'code' => 'UVA_HIGH',
            ],
            [
                'name' => 'West High',
                'code' => 'WEST_HIGH',
            ],
            [
                'name' => 'CTC High',
                'code' => 'CTC_HIGH',
            ],
            [
                'name' => 'High Summary',
                'code' => 'HIGH_SUMMARY',
            ],
            [
                'name' => 'Uva Medium',
                'code' => 'UVA_MEDIUM',
            ],
            [
                'name' => 'Western Medium',
                'code' => 'WESTERN_MEDIUM',
            ],
            [
                'name' => 'CTC Medium',
                'code' => 'CTC_MEDIUM',
            ],
            [
                'name' => 'Med. Summary',
                'code' => 'MEDIUM_SUMMARY',
            ],
            [
                'name' => 'Orthodox Low',
                'code' => 'ORTHODOX_LOW',
            ],
            [
                'name' => 'CTC Low',
                'code' => 'CTC_LOW',
            ],
            [
                'name' => 'Low Summary',
                'code' => 'LOW_SUMMARY',
            ],
            [
                'name' => 'Total',
                'code' => 'TOTAL',
            ],
        ]);
    }
}
