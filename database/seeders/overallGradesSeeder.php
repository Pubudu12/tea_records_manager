<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class overallGradesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('overall_grades')->insert([
            [
                'reference_overall_elevations_id' => '1',
                'tea_grade' => 'BOP',
            ],
            [
                'reference_overall_elevations_id' => '1',
                'tea_grade' => 'BOPF',
            ],
            [
                'reference_overall_elevations_id' => '8',
                'tea_grade' => 'BP1',
            ],
            [
                'reference_overall_elevations_id' => '8',
                'tea_grade' => 'PF1',
            ],
            [
                'reference_overall_elevations_id' => '12',
                'tea_grade' => 'FBOP',
            ],
            [
                'reference_overall_elevations_id' => '12',
                'tea_grade' => 'PEK',
            ],
            [
                'reference_overall_elevations_id' => '16',
                'tea_grade' => 'BEST',
            ],
            [
                'reference_overall_elevations_id' => '16',
                'tea_grade' => 'BELLOW BEST',
            ],
            [
                'reference_overall_elevations_id' => '16',
                'tea_grade' => 'OTHER',
            ],
            [
                'reference_overall_elevations_id' => '20',
                'tea_grade' => 'BEST',
            ],
            [
                'reference_overall_elevations_id' => '20',
                'tea_grade' => 'BELLOW BEST',
            ],
            [
                'reference_overall_elevations_id' => '20',
                'tea_grade' => 'OTHER',
            ],
            [
                'reference_overall_elevations_id' => '24',
                'tea_grade' => 'HIGH & MED',
            ],
            [
                'reference_overall_elevations_id' => '24',
                'tea_grade' => 'LOW',
            ],
            [
                'reference_overall_elevations_id' => '24',
                'tea_grade' => 'CTC',
            ],
            [
                'reference_overall_elevations_id' => '27',
                'tea_grade' => 'HIGH & MED',
            ],
            [
                'reference_overall_elevations_id' => '27',
                'tea_grade' => 'LOW',
            ],
            [
                'reference_overall_elevations_id' => '27',
                'tea_grade' => 'CTC',
            ],
        ]);
    }
}
