<?php

namespace App\Http\Controllers\_PDF\Colombo_auctions;

use App\Http\Controllers\Controller;
use App\Models\reference_market_rows_columns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketAnalysisController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');  
            
            return $next($request);
        });
    }

    public function getMarketDescriptions($elevation = 'HIGH_GROWN'){

        $marketRefDetails = reference_market_rows_columns::select('id')
                            ->where('code', '=',$elevation)
                            ->first();  
        
        $fetchData = DB::table('market_descriptions') 
                        ->where('sales_code', '=',$this->session_sale_code)
                        ->where('elevation_id', '=', $marketRefDetails->id)
                        ->select('tea_grade','description',)
                        ->get(); 

        return json_decode($fetchData);
    }//getMarketDescriptions

    
    public function getMarketAnalysisDetails($elevation = 'HIGH_GROWN'){

        $marketRefDetails = reference_market_rows_columns::select('id')
                            ->where('code', '=',$elevation)
                            ->first();  
        
        $fetchData = DB::table('market_analysis_details') 
                        ->where('sales_code', '=',$this->session_sale_code)
                        ->where('elevation_id', '=', $marketRefDetails->id)
                        ->select('name','values','status_values','type')
                        ->get(); 

        return json_decode($fetchData);
    }//getMarketAnalysisDetails

    public function fetchMarketDescriptions(){
        
        $dataArray = $this->getMarketDescriptions();
        
        return $dataArray;

    }//fetchMarketDescriptions


    public function fetchMarketDetails(){
        
        $dataArray = $this->getMarketAnalysisDetails();
        
        return $dataArray;

    }//fetchMarketDetails
}
