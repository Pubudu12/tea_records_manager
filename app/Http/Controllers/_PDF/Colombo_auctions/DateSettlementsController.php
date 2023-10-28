<?php

namespace App\Http\Controllers\_PDF\Colombo_auctions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DateSettlementsController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');  
            
            return $next($request);
        });
    }

    private function getDateSettlements(){
        $dataSet =  DB::table('settlement_dates')
                        ->where('sale_code','=',$this->session_sale_code)
                        ->select('type','small_desc','date')
                        ->get();

         return $dataSet;

    }//getDateSettlements


    public function fetchDateSettlements(){
        
        $dataArray = $this->getDateSettlements();
        
        return $dataArray;

    }//fetchDateSettlements
}
