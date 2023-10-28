<?php

namespace App\Http\Controllers\_PDF\Auction_highlights;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuctionHighlightsController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');  
            
            return $next($request);
        });
    }

    private function getAuctionDescriptions(){
        $dataset = DB::table('auction_descriptions')
                        ->where('sale_code','=',$this->session_sale_code)
                        ->select('description_title','description','type')
                        ->get();

        return $dataset;
    }//getAuctionDescriptions


    public function fetchAuctionDescriptions(){
        $auctionDescriptionArray = array();

        $auctionDescriptionArray = $this->getAuctionDescriptions();

        return $auctionDescriptionArray;

    }//fetchAuctionDescriptions

}
