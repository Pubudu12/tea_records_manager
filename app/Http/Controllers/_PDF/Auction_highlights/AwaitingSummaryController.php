<?php

namespace App\Http\Controllers\_PDF\Auction_highlights;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AwaitingSummaryController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');  
            
            return $next($request);
        });
    }

    private function getAwaitingSummary(){
        
        $awaitingSumaryDetails = DB::table('awaiting_lots_qty_summary')
                                    ->where('sales_code','=',$this->session_sale_code)
                                    ->select('quantity','lots')
                                    ->get();

        return $awaitingSumaryDetails;

    }//getAwaitingSummary


    public function fetchAwaitingSummary(){
        $awaitingSumaryDetails = array();

        $awaitingSumaryDetails = $this->getAwaitingSummary();

        return $awaitingSumaryDetails;

    }//fetchAwaitingSummary
}
