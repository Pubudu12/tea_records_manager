<?php

namespace App\Http\Controllers\_PDF\Auction_highlights;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OverallMarketController extends Controller
{

    public function __construct(){
        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');  
            
            return $next($request);
        });
    }

    private function getOverallDetails(){
        $dataSet = DB::table('overall_market')
                       ->leftJoin('reference_overall_market','reference_overall_market.id','=','overall_market.reference_overall_market_id')
                       ->where('overall_market.sales_code','=',$this->session_sale_code)
                       ->select('overall_market.quantity_m_kgs','overall_market.demand','reference_overall_market.name')
                       ->get();

         return $dataSet;

    }//getOverallDetails


    public function fetchOverallDetails(){
        
        $overallArray = $this->getOverallDetails();
        
        return $overallArray;

    }//fetchOverallDetails
}

