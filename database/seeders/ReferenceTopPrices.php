<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\reference_top_prices;

class ReferenceTopPrices extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        {
            reference_top_prices::where('level', '=', '2')->delete();
            reference_top_prices::where('level', '=', '1')->delete();
            reference_top_prices::insert([
                [
                    'name' => 'Western Medium',
                    'list_order' => '1',
                    'code' => 'WM',
                    'parent_code' => '',
                    'level' => '1',
                ],

                    [
                        'name' => 'Doombagastalawa',
                        'list_order' => '1',
                        'code' => 'WM-DOOMBA',
                        'parent_code' => 'WM',
                        'level' => '2',
                    ],
                    [
                        'name' => 'Harangalla',
                        'list_order' => '1',
                        'code' => 'WM-HARANG',
                        'parent_code' => 'WM',
                        'level' => '2',
                    ],
                    [
                        'name' => 'Imboolpittia',
                        'list_order' => '1',
                        'code' => 'WM-IMBOOL',
                        'parent_code' => 'WM',
                        'level' => '2',
                    ],
                    [
                        'name' => 'Craighead',
                        'list_order' => '1',
                        'code' => 'WM-CRAIGH',
                        'parent_code' => 'WM',
                        'level' => '2',
                    ],

                [
                    'name' => 'Western High',
                    'list_order' => '2',
                    'code' => 'WH',
                    'parent_code' => '',
                    'level' => '1',
                ],
                    [
                        'name' => 'Imboolpittia',
                        'list_order' => '1',
                        'code' => 'WH-IMBOOL',
                        'parent_code' => 'WH',
                        'level' => '2',
                    ],
                    [
                        'name' => 'Craighead',
                        'list_order' => '1',
                        'code' => 'WH-CRAIGH',
                        'parent_code' => 'WH',
                        'level' => '2',
                    ],
                    [
                        'name' => 'Torrington',
                        'list_order' => '1',
                        'code' => 'WH-TORRIN',
                        'parent_code' => 'WH',
                        'level' => '2',
                    ],
                    [
                        'name' => 'Bogahawatte',
                        'list_order' => '1',
                        'code' => 'WH-BOGAHA',
                        'parent_code' => 'WH',
                        'level' => '2',
                    ],

                [
                    'name' => 'Nuwara Eliya',
                    'list_order' => '3',
                    'code' => 'NE',
                    'parent_code' => '',
                    'level' => '1',
                ],
                    [
                        'name' => 'Doombagastalawa',
                        'list_order' => '1',
                        'code' => 'NE-BOOMBA',
                        'parent_code' => 'NE',
                        'level' => '2',
                    ],
                    [
                        'name' => 'Harangalla',
                        'list_order' => '1',
                        'code' => 'NE-HARANG',
                        'parent_code' => 'NE',
                        'level' => '2',
                    ],
                    [
                        'name' => 'Imboolpittia',
                        'list_order' => '1',
                        'code' => 'NE-IMBOOL',
                        'parent_code' => 'NE',
                        'level' => '2',
                    ],
                    [
                        'name' => 'Craighead',
                        'list_order' => '1',
                        'code' => 'NE-CRAIGH',
                        'parent_code' => 'NE',
                        'level' => '2',
                    ],


                [
                    'name' => 'Udapussellawas',
                    'list_order' => '4',
                    'code' => 'UD',
                    'parent_code' => '',
                    'level' => '1',
                ],
                [
                    'name' => 'Uva High',
                    'list_order' => '5',
                    'code' => 'UH',
                    'parent_code' => '',
                    'level' => '1',
                ],
                [
                    'name' => 'Uva Medium',
                    'list_order' => '6',
                    'code' => 'UM',
                    'parent_code' => '',
                    'level' => '1',
                ],
                [
                    'name' => 'Unorthodox Medium',
                    'list_order' => '7',
                    'code' => 'UO',
                    'parent_code' => '',
                    'level' => '1',
                ],
                [
                    'name' => 'Unorthodox Low',
                    'list_order' => '8',
                    'code' => 'UL',
                    'parent_code' => '',
                    'level' => '1',
                ],
                [
                    'name' => 'Low Grown',
                    'list_order' => '9',
                    'code' => 'LG',
                    'parent_code' => '',
                    'level' => '1',
                ],
                [
                    'name' => 'Premium Flowery',
                    'list_order' => '10',
                    'code' => 'PF',
                    'parent_code' => '',
                    'level' => '1',
                ],
                [
                    'name' => 'Dusts',
                    'list_order' => '11',
                    'code' => 'DU',
                    'parent_code' => '',
                    'level' => '1',
                ],
                [
                    'name' => 'Off Grades',
                    'list_order' => '12',
                    'code' => 'OG',
                    'parent_code' => '',
                    'level' => '1',
                ],

                [
                    'name' => 'Western High',
                    'list_order' => '14',
                    'code' => 'HGT',
                    'parent_code' => '',
                    'level' => '1',
                ],
            ]);
        }


    }
}
