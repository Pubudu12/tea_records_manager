<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\reference_market_rows_columns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColomboAuctionsAPIController extends Controller
{
    
    public function orderOfSales($sale_code){
        
        $fetchData = DB::table('order_of_sale_details')
                        ->where('sale_code','=',$sale_code)
                        ->select('column_1_details','column_2_details','column_3_details')
                        ->get();

        return json_decode($fetchData);
    }//orderOfSales


    public function dateSettlements($sale_code){
        
        $fetchData = DB::table('settlement_dates')
                        ->where('sale_code','=',$sale_code)
                        ->select('type','small_desc','date')
                        ->get();

        return json_decode($fetchData);
    }//dateSettlements


    public function fetchCropANdWeather($sale_code){
        // $cropDetails = DB::table('crop_and_weather')
        //                     ->where('sale_code','=',$sale_code)
        //                     ->where('type','=','CROP')
        //                     ->first();

        $fetchData = DB::table('crop_and_weather')
                            ->where('sale_code','=',$sale_code)
                            ->select('type','date_duration','title','small_description','weather')
                            ->get();

        return json_decode($fetchData);
    }


    public function fetchMarketDescriptions($sale_code,$elevation){

        $marketRefDetails = reference_market_rows_columns::select('id')
                            ->where('code', '=',$elevation)
                            ->first();  
        
        $fetchData = DB::table('market_descriptions') 
                        ->where('sales_code', '=',$sale_code)
                        ->where('elevation_id', '=', $marketRefDetails->id)
                        ->select('tea_grade','description',)
                        ->get(); 

        return json_decode($fetchData);
    }//fetchMarketDescriptions

    
    public function fetchMarketAnalysisDetails($sale_code,$elevation){

        $marketRefDetails = reference_market_rows_columns::select('id')
                            ->where('code', '=',$elevation)
                            ->first();  
        
        $fetchData = DB::table('market_analysis_details') 
                        ->where('sales_code', '=',$sale_code)
                        ->where('elevation_id', '=', $marketRefDetails->id)
                        ->select('name','values','status_values','type')
                        ->get(); 

        return json_decode($fetchData);
    }//fetchMarketAnalysisDetails


    public function fetchTopPrices($sale_code){
        
        $fetchData = DB::table('reference_top_prices')
                            ->leftjoin('top_prices','top_prices.mark_code','=','reference_top_prices.code')
                            ->where('top_prices.sale_code','=', $sale_code)
                            ->select('reference_top_prices.id', 'reference_top_prices.code', 'reference_top_prices.name', 'reference_top_prices.parent_code', 'reference_top_prices.level',
                                    'top_prices.varities','top_prices.is_forbes', 'top_prices.asterisk', 'top_prices.value')
                            ->orderBy('top_prices.created', 'DESC')
                            ->get();

        return json_decode($fetchData);
    }//fetchTopPrices

}
