<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;

trait ReportPreviousData{

    private function previousSaleCodes($currectSaleCode,$numberOfSales){
        $num = 0;
        $year = 0;
        $saleCodeDetailArray = array();

        if($currectSaleCode != NULL){
            $pieces = str_split($currectSaleCode,4);
            $no = str_split($pieces[1],1);
                    
            for ($i = 1; $i <= $numberOfSales; $i++) { 

                $num = $no[1].$no[2];

                $year = $pieces[0];
                $num = $num - $i;
                $numlength = strlen((string)$num);
                if ($num <= 0) {
                    $year = $year - $i;                
                }
                if ($numlength == 1) {
                    $num = '0'.$num;
                }
                
                $saleCodeDetailArray[$i] = array(
                    'year'=>$year,
                    'number'=>$num,
                    'sale_code'=>$year.'-'.$num,
                );
            }            
        }

        return $saleCodeDetailArray;
    }//previousSaleCodes

    
    private function previousSaleNumbers($currectSaleCode,$numberOfSales){
        $num = 0;
        $saleCodeDetailArray = array();

        if($currectSaleCode != NULL){
            $pieces = str_split($currectSaleCode,4);
            $no = str_split($pieces[1],1);
                    
            for ($i = 1; $i <= $numberOfSales; $i++) { 

                $num = $no[1].$no[2];

                $num = $num - $i;
                $numlength = strlen((string)$num);
                
                if ($numlength == 1) {
                    $num = '0'.$num;
                }
                
                $saleCodeDetailArray[$i] = array(
                    'number'=>$num,
                    'sale_code'=>$pieces[0].'-'.$num
                );
            }            
        }

        return $saleCodeDetailArray;
    }//previousSaleNumbers
}