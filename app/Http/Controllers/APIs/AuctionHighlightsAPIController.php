<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Traits\APITrait;
use App\Models\market_descriptions;
use App\Models\reference_market_rows_columns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuctionHighlightsAPIController extends Controller
{
    use APITrait;

    public function fetchMarketReportMainDetails($sale_code){
        
        $fetchData = DB::table('sales_list')
                        ->leftjoin('months','months.id','=','sales_list.month')
                        ->where('sales_list.sales_code','=',$sale_code)                        
                        ->select('sales_list.title','sales_list.year','months.name','sales_list.current_dollar_value','sales_list.report_day_one',
                                'sales_list.report_day_two','sales_list.buyers_prompt_date','sales_list.sellers_prompt_date',
                                'sales_list.published','sales_list.published_date')
                        ->get();

        return json_decode($fetchData);
    }//fetchMarketReportMainDetails


    public function fetchMarketDashboard($sale_code){
        // $fetchPreviousData = $this->fetchPreviousData();

        $fetchData = DB::table('details_of_qualtity_sold')
                        ->where('sale_code','=',$sale_code)
                        ->select('quantity_m_kgs','avg_price_lkr','avg_price_usd')
                        ->get();

        // return json_decode($fetchData);
        return response()->json($fetchData,200);
    }//fetchMarketDashboard


    public function fetchOverall($sale_code){
        $fetchData = DB::table('overall_market')
                            ->leftjoin('reference_overall_market', 'reference_overall_market.id', '=', 'overall_market.reference_overall_market_id')
                            ->where('overall_market.sales_code','=',$sale_code)
                            ->select('reference_overall_market.name AS refName','reference_overall_market.id AS refID','overall_market.quantity_m_kgs','overall_market.demand')
                            ->get();

        return json_decode($fetchData);
    }//fetchOverall


    public function fetchOverallDetails($sale_code){
        $fetchData = DB::table('overall_detail_values')
                        ->leftjoin('reference_overall_elevations','reference_overall_elevations.code','=','overall_detail_values.reference_elevation')
                        ->where('overall_detail_values.sales_code','=',$sale_code)
                        ->select('overall_detail_values.*','reference_overall_elevations.order','reference_overall_elevations.name','overall_detail_values.reference_elevation','reference_overall_elevations.level','reference_overall_elevations.parent_category','reference_overall_elevations.column_includes','overall_detail_values.overall_detail_values','overall_detail_values.overall_status_values')
                        ->get();

        return json_decode($fetchData);
    }//fetchOverallDetails


    public function auctionDescriptions($sale_code){
        
        $fetchData = DB::table('auction_descriptions')
                        ->where('sale_code','=',$sale_code)
                        ->select('description_title','description','type')
                        ->get();

        return json_decode($fetchData);
    }//auctionDescriptions

}
