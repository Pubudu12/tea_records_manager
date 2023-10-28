<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class referenceAwaitingLotsAndQty extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reference_awaiting_lots_quantity')->insert([
            [
                'name' => 'Ex Estate',
                'code' => 'EXES',
                'ref_order' => '1',
                'type'=>'VALUE'
            ],
            [
                'name' => 'Main Sale - High & Medium',
                'code' => 'HIGHMD',
                'ref_order' => '2',
                'type'=>'VALUE'
            ],
            [
                'name' => 'Low Grown - Leafy',
                'code' => 'LF',
                'ref_order' => '3',
                'type'=>'VALUE'
            ],
            [
                'name' => 'Low Grown - Semi Leafy',
                'code' => 'SLF',
                'ref_order' => '4',
                'type'=>'VALUE'
            ],
            [
                'name' => 'Low Grown - Tippy',
                'code' => 'TIPPY',
                'ref_order' => '5',
                'type'=>'VALUE'
            ],
            [
                'name' => 'Premium Flowery',
                'code' => 'PF',
                'ref_order' => '6',
                'type'=>'VALUE'
            ],
            [
                'name' => 'Off Grade',
                'code' => 'OG',
                'ref_order' => '7',
                'type'=>'VALUE'
            ],
            [
                'name' => 'Dust',
                'code' => 'DUST',
                'ref_order' => '8',
                'type'=>'VALUE'
            ],            
            [
                'name' => 'Total',
                'code' => 'TOTAL',
                'ref_order' => '9',
                'type'=>'TOTAL'
            ],
            [
                'name' => 'Re Prints',
                'code' => 'REPRINTS',
                'ref_order' => '10',
                'type'=>'VALUE'
            ],
        ]);
    }
}
