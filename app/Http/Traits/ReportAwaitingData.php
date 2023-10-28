<?php

namespace App\Http\Traits;

trait ReportAwaitingData{

    public function getAwaitingSaleNumber($sale_code,$sequence){
        $pieces = str_split($sale_code,4);
        $no = str_split($pieces[1],1);
        $awaiting_sale_code = $no[1].$no[2];
    
        $awaiting_sale_code = $awaiting_sale_code+$sequence;
    
        if (strlen($awaiting_sale_code) == 1) {
            $awaiting_sale_code = '0'.$awaiting_sale_code;
        }
        $awaiting_sale_code = $pieces[0].'-'.$awaiting_sale_code;
        
        return $awaiting_sale_code;
    
    }//getAwaitingSaleNumber

}
?>