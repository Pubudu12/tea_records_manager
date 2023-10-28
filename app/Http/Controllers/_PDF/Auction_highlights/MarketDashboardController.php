<?php

namespace App\Http\Controllers\_PDF\Auction_highlights;
use App\Http\Controllers\Controller;
use App\Http\Traits\MarketDashboardTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketDashboardController extends Controller{

    use MarketDashboardTrait;

    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');  
            
            return $next($request);
        });
    }
    
    public function fetchMarketDashboardDetails(){
        
        $marketDashboardCurrentData = array();

        $previousData = $this->fetchMarketDashboardData($this->session_sale_code);

        $data = DB::table('details_of_qualtity_sold');

        return $previousData;
    }


    public function fetchOverallMarket(){
        
        $overallMarketDetails = array();

        $previousData = $this->fetchMarketDashboardData($this->session_sale_code);

        $data = DB::table('details_of_qualtity_sold');

        return $previousData;
    }



}
