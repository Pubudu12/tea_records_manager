<?php

namespace App\Http\Controllers;

use App\Http\Traits\DBOperationsTrait;
use App\Models\auction_descriptions;
use App\Models\crop_and_weather;
use App\Models\details_of_qualtity_sold;
use App\Models\major_importers_details;
use App\Models\major_importers_main;
use App\Models\market_analysis_details;
use App\Models\market_descriptions;
use App\Models\nation_wide_tea_descriptions;
use App\Models\order_of_sale_details;
use App\Models\overall_detail_values;
use App\Models\overall_market;
use App\Models\public_auction_sale_details;
use App\Models\public_auction_sale_main;
use App\Models\quantity_sold_summary;
use App\Models\rates_of_exchange;
use App\Models\sales_list;
use App\Models\settlement_dates;
use App\Models\sri_lanka_tea_export_main;
use App\Models\srilankan_tea_exports_details;
use App\Models\srilankan_tea_production_details;
use App\Models\tea_market_descriptions;
use App\Models\topPrices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteMarketReportController extends Controller
{

    use DBOperationsTrait;

    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');

            return $next($request);
        });
    }


    public function deleteTableData($sale_code){
        $statusArr = array();

        // market Dashboard availability check & delete
        $fetchMarketDashboard = $this->fetchDetailsBySalesCode(new details_of_qualtity_sold(), 'sale_code', $sale_code);
        if ($fetchMarketDashboard != NULL) {
            $deleteMarketDashboard = details_of_qualtity_sold::where('sale_code', $sale_code)
                                                             ->delete();
            $statusArr[] = ['marketDashboard'=>$deleteMarketDashboard];
        }

        // Overall Market availability check & delete
        $fetchoverallMarket = $this->fetchDataSetBySaleCode(new overall_market(), 'sales_code', $sale_code);
        if (count($fetchoverallMarket) > 0) {
            $deleteOverall = overall_market::where('sales_code', $sale_code)
                                                             ->delete();
            $statusArr[] = ['overallMarket'=>$deleteOverall];
        }

        // Overall Market Details availability check & delete
        $overallMarketDetails = $this->fetchDataSetBySaleCode(new overall_detail_values(), 'sales_code', $sale_code);
        if (count($overallMarketDetails) > 0) {
            $deleteOverallMkDetails = overall_detail_values::where('sales_code', $sale_code)
                                                             ->delete();
            $statusArr[] = ['overallMarketDetails'=>$deleteOverallMkDetails];
        }

        // Auction Descriptions availability check & delete
        $auctionDescriptions = $this->fetchDataSetBySaleCode(new auction_descriptions(), 'sale_code', $sale_code);
        if (count($auctionDescriptions) > 0) {
            $deleteAuctionDesc = auction_descriptions::where('sale_code', $sale_code)
                                                            ->delete();
            $statusArr[] = ['auctionDescriptions'=>$deleteAuctionDesc];
        }

        // Oder of Sales availability check & delete
        $orderOfSales = $this->fetchDataSetBySaleCode(new order_of_sale_details(), 'sale_code', $sale_code);
        if (count($orderOfSales) > 0) {
            $deleteOrderOfSales = order_of_sale_details::where('sale_code', $sale_code)
                                                             ->delete();
            $statusArr[] = ['orderOfSales'=>$deleteOrderOfSales];
        }

        // Settlement of dates availability check & delete
        $settlemetDates = $this->fetchDataSetBySaleCode(new settlement_dates(), 'sale_code', $sale_code);
        if (count($settlemetDates) > 0) {
            $deleteSettlemetDates = settlement_dates::where('sale_code', $sale_code)
                                                            ->delete();
            $statusArr[] = ['settlemetDates'=>$deleteSettlemetDates];
        }

        // Crop and weather availability check & delete
        $cropWeather = $this->fetchDataSetBySaleCode(new crop_and_weather(), 'sale_code', $sale_code);
        if (count($cropWeather) > 0) {
            $deleteCropWeather = crop_and_weather::where('sale_code', $sale_code)
                                                            ->delete();
            $statusArr[] = ['cropWeather'=>$deleteCropWeather];
        }

        // Market Analysis Descriptions availability check & delete
        $marketAnalysisDesc = $this->fetchDataSetBySaleCode(new market_descriptions(), 'sales_code', $sale_code);
        if (count($marketAnalysisDesc) > 0) {
            $deleteMarketAnalysisDesc = market_descriptions::where('sales_code', $sale_code)
                                                            ->delete();
            $statusArr[] = ['marketAnalysisDesc'=>$deleteMarketAnalysisDesc];
        }

        // Market Analysis Details availability check & delete
        $marketAnalysisDetails = $this->fetchDataSetBySaleCode(new market_analysis_details(), 'sales_code', $sale_code);
        if (count($marketAnalysisDetails) > 0) {
            $deleteMarketAnalysisDetails = market_analysis_details::where('sales_code', $sale_code)
                                                            ->delete();
            $statusArr[] = ['marketAnalysisDetails'=>$deleteMarketAnalysisDetails];
        }

        // top_prices availability check & delete
        $topPrices = $this->fetchDataSetBySaleCode(new topPrices(), 'sale_code', $sale_code);
        if (count($topPrices) > 0) {
            $deleteTopPrices = topPrices::where('sale_code', $sale_code)
                                                            ->delete();
            $statusArr[] = ['top_prices'=>$deleteTopPrices];
        }

        // Nation wide tea descriptions availability check & delete
        $nationTeaDesc = $this->fetchDataSetBySaleCode(new nation_wide_tea_descriptions(), 'sales_code', $sale_code);
        if (count($nationTeaDesc) > 0) {
            $deleteTeaDesc = nation_wide_tea_descriptions::where('sales_code', $sale_code)
                                                            ->delete();
            $statusArr[] = ['nationTeaDesc'=>$deleteTeaDesc];
        }


        // Quantity sold details availability check & delete
        $qtySold = $this->fetchDataSetBySaleCode(new quantity_sold_summary(), 'sales_code', $sale_code);
        if (count($qtySold) > 0) {
            $deleteQtySold = quantity_sold_summary::where('sales_code', $sale_code)
                                                            ->delete();
            $statusArr[] = ['qtySold'=>$deleteQtySold];
        }

        // Rates of exchange availability check & delete
        $ratesOfExchange = $this->fetchDetailsBySalesCode(new rates_of_exchange(), 'sales_code', $sale_code);
        if ($ratesOfExchange != NULL) {
            $deleteRatesExchange = rates_of_exchange::where('sales_code', $sale_code)
                                                            ->delete();
            $statusArr[] = ['ratesOfExchange'=>$deleteRatesExchange];
        }


        // Public Auction availability check & delete
        $publicAuction = $this->fetchDetailsBySalesCode(new public_auction_sale_main(), 'sales_code', $sale_code);
        if ($publicAuction != NULL) {
            $fetch = DB::table('public_auction_sale_main')
                                        ->where('sales_code','=',$sale_code)
                                        ->select('id')
                                        ->first();

            $auctionManiId = $fetch->id;

            $deletePublicAuctionDetails = public_auction_sale_details::where('public_auction_main_id', $auctionManiId)
                                                                    ->delete();
            
            $deletePublicAucMain = public_auction_sale_main::where('sales_code', $sale_code)
                                                            ->delete();
            
                                                            
            $statusArr[] = ['publicAuction'=>$deletePublicAuctionDetails];
        }


        // Sri Lanka Tea Production availability check & delete
        $sriLankaTeaProduction = $this->fetchDataSetBySaleCode(new srilankan_tea_production_details(), 'sale_code', $sale_code);
        if (count($sriLankaTeaProduction) > 0) {
            $deletesriLankanTeaProd = srilankan_tea_production_details::where('sale_code', $sale_code)
                                                                        ->delete();
            $statusArr[] = ['srilankaTeaProduction'=>$deletesriLankanTeaProd];
        }


        // Sri Lanka Tea exports availability check & delete
        $sriLankanTeaExports = $this->fetchDetailsBySalesCode(new sri_lanka_tea_export_main(), 'sale_code', $sale_code);
        if ($sriLankanTeaExports != NULL) {
            $fetch = DB::table('sri_lanka_tea_export_main')
                                        ->where('sale_code','=',$sale_code)
                                        ->select('id')
                                        ->first();

            $mainId = $fetch->id;

            $deletePublicAuctionDetails = srilankan_tea_exports_details::where('tea_export_main_id', $mainId)
                                                                        ->delete();
            
            $deleteSriLankanExports = sri_lanka_tea_export_main::where('sale_code', $sale_code)
                                                                ->delete();            
                                                            
            $statusArr[] = ['sriLankanExports'=>$deleteSriLankanExports];
        }


        // Major Importers availability check & delete
        $majorImporters = $this->fetchDetailsBySalesCode(new major_importers_main(), 'sales_code', $sale_code);
        if ($majorImporters != NULL) {
            // $fetch = DB::table('major_importers_main')
            //                             ->where('sales_code','=',$sale_code)
            //                             ->select('id')
            //                             ->first();
            $mainId = $majorImporters->id;

            $deleteMajorImpDetails = major_importers_details::where('importers_main_id', $mainId)
                                                                   ->delete();
            
            $deleteMajorImpMain = major_importers_main::where('sales_code', $sale_code)
                                                                ->delete();            
                                                            
            $statusArr[] = ['majorImporters'=>$deleteMajorImpMain];
        }


        // tea_market_descriptions availability chec and delete
        $worldTeaDesc = $this->fetchDataSetBySaleCode(new tea_market_descriptions(), 'sales_code', $sale_code);
        if (count($worldTeaDesc) > 0) {
            $deleteWorldTeaDesc = tea_market_descriptions::where('sales_code', $sale_code)
                                                            ->delete();
            $statusArr[] = ['worldTeaDesc'=>$deleteWorldTeaDesc];
        }

        return $statusArr;

    }//deleteTableData


    public function deleteMarketReport($sale_code){
        $message = 'Failed to delete!';
        $result = 0;
        $redirect = '';

        $deleteTableData = $this->deleteTableData($sale_code);

        $deleteMarketReport = sales_list::where('sales_code', $sale_code)
                                            ->delete();
        
        if ($deleteMarketReport) {
            $message = 'Successfully deleted the market report!';
            $result = 1;
            $redirect = '/dashboard';
        }

        return json_encode(array(
            'message' => $message,
            'result' =>$result,
            'status'=>$deleteTableData,
            'redirect'=> $redirect 
         ), 200);
    }//deleteMarketReport
}
