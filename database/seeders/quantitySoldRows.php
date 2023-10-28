<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class quantitySoldRows extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quantity_sold_rows')->insert([
            [
                'row_name' => 'Private Sales',
                'code' => 'PrivateSales',
            ],
            [
                'row_name' => 'Public Auction',
                'code' => 'PublicAuction',
            ],
            [
                'row_name' => 'Forward Contracts',
                'code' => 'ForwardContracts',
            ],
            [
                'row_name' => 'Direct Sales',
                'code' => 'DirectSales',
            ],
            [
                'row_name' => 'Total',
                'code' => 'TOTAL',
            ],
            [
                'row_name' => 'BMF Excluded from Private Sale',
                'code' => 'BMF',
            ],            
        ]);
    }
}
