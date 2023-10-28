<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefSriLankanTeaExports extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reference_srilankan_tea_exports')->insert([
            [
                'name' => 'Tea In Bulk'
            ],
            [
                'name' => 'Tea In Packets'
            ],
            [
                'name' => 'Tea In Bags'
            ],
            [
                'name' => 'Instant Tea'
            ],
            [
                'name' => 'Green Tea'
            ],      
            [
                'name' => 'Total'
            ], 
        ]);
    }
}
