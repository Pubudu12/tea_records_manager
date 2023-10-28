<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function calculateRowTotal($totalCalculationsArray){
        $count = count($totalCalculationsArray);
        $totalArray = array();

        foreach ($totalCalculationsArray[1] as $key => $value) {            
                        
            // $t = (float)$value + (float)$totalCalculationsArray[2][$key] + (float)$totalCalculationsArray[3][$key] + (float)$totalCalculationsArray[4][$key] + (float)$totalCalculationsArray[5][$key];
            
            $total = 0;

            for ($i=1; $i <= $count; $i++) { 
                if ($totalCalculationsArray[$i][$key] != NULL) {
                    $total += (float)$totalCalculationsArray[$i][$key];         
                }
            }

            $totalArray[$key] = $total;
            // print_r($total);
            //     print_r('<br>');

        }
        // print_r($totalArray);
        return $totalArray;
    }//calculateRowTotal
}
