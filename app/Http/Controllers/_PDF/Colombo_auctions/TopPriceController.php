<?php

namespace App\Http\Controllers\_PDF\Colombo_auctions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopPriceController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');  
            
            return $next($request);
        });
    }

    private function getTopPrices(){
        $dataSet = DB::table('reference_top_prices')
                        ->leftjoin('top_prices','top_prices.mark_code','=','reference_top_prices.code')
                        ->where('top_prices.sale_code','=', $this->session_sale_code)
                        ->select('reference_top_prices.id', 'reference_top_prices.code', 'reference_top_prices.name', 'reference_top_prices.parent_code', 'reference_top_prices.level',
                                'top_prices.varities','top_prices.is_forbes', 'top_prices.asterisk', 'top_prices.value')
                        ->get();

         return $dataSet;

    }//getTopPrices


    public function fetchTopPrices(){
        
        $dataArray = $this->getTopPrices();
        
        return $dataArray;

    }//fetchTopPrices
}
