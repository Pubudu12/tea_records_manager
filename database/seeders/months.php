<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class months extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('months')->insert([
            [
                'name' => 'January',
                'code' => 'JANUARY',
            ],
            [
                'name' => 'February',
                'code' => 'FEBRUARY',
            ],
            [
                'name' => 'March',
                'code' => 'MARCH',
            ],
            [
                'name' => 'April',
                'code' => 'APRIL',
            ],
            [
                'name' => 'May',
                'code' => 'MAY',
            ],
            [
                'name' => 'June',
                'code' => 'JUNE',
            ],
            [
                'name' => 'July',
                'code' => 'JULY',
            ],
            [
                'name' => 'August',
                'code' => 'AUGUST',
            ],
            [
                'name' => 'September',
                'code' => 'SEPTEMBER',
            ],
            [
                'name' => 'October',
                'code' => 'OCTOBER',
            ],
            [
                'name' => 'November',
                'code' => 'NOVEMBER',
            ],
            [
                'name' => 'December',
                'code' => 'DECEMBER',
            ],
        ]);
    }
}
