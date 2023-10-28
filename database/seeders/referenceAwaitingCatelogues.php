<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class referenceAwaitingCatelogues extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reference_awaiting_catelogues')->insert([
            [
                'name' => 'Low Grown Catalogues',
                'code'=>'LOW_GROWN_CTALG',
                'catelogue_references' => '["LEAFY","SEMI-LEAFY","TIPPY"]',
            ],
            [
                'name' => 'Other Main Sale Catalogues',
                'code'=>'OTHER_MAIN_CTALG',
                'catelogue_references' => '["HIGH & MEDIUM","PREMIUM FLOWERY","OFF GRADES","DUST","BOP1A","EX ESTATE"]',
            ],
        ]);
    }
}
