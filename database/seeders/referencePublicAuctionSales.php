<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class referencePublicAuctionSales extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reference_public_auction_sales')->insert([
            [  'name'=>'Uva High',
                'code'=>'UH',
                'type'=>'VALUE'  
            ],
            [
                'name'=>'West High',
                'code'=>'WH',
                'type'=>'VALUE' 
            ],     
            [
                'name'=>'CTC High',
                'code'=>'CTCH',
                'type'=>'VALUE' 
            ],
            [
                'name'=>'High Summary',
                'code'=>'HS',
                'type'=>'VALUE' 
            ],    
            [
                'name'=>'Uva Medium',
                'code'=>'UM',
                'type'=>'VALUE' 
            ],
            [
                'name'=>'Western Medium',
                'code'=>'WM',
                'type'=>'VALUE' 
            ],
            [
                'name'=>'CTC Medium',
                'code'=>'CTCM',
                'type'=>'VALUE' 
            ],
            [
                'name'=>'Medium Summary',
                'code'=>'MS',
                'type'=>'VALUE' 
            ],
            [
                'name'=>'Orthodox Low',
                'code'=>'OL',
                'type'=>'VALUE' 
            ],
            [
                'name'=>'CTC Low',
                'code'=>'CTCL',
                'type'=>'VALUE' 
            ],
            [
                'name'=>'Low Summary',
                'code'=>'LS',
                'type'=>'VALUE' 
            ],
            [
                'name'=>'Total',
                'code'=>'Total',
                'type'=>'TOTAL' 
            ],
        ]);
    }
}
