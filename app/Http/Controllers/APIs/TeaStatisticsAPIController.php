<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeaStatisticsAPIController extends Controller
{
    public function fetchQualitySold($sale_code){
        
        $fetchData = DB::table('quantity_sold_summary')
                                ->leftjoin('quantity_sold_rows', 'quantity_sold_rows.id', '=', 'quantity_sold_summary.quantity_sold_row_id')
                                ->where('quantity_sold_summary.sales_code','=',$sale_code)
                                ->select('quantity_sold_rows.row_name','quantity_sold_summary.*')
                                ->get();

        return json_decode($fetchData);
    }//fetchQualitySold


    public function fetchPreviousData(){
        # code...
    }//fetchPreviousData


    public function fetchRatesOfExchanges($sale_code){
        
        $fetchData = DB::table('rates_of_exchange')
                        ->where('sales_code','=',$sale_code)
                        ->get();

        return json_decode($fetchData);
    }//fetchRatesOfExchanges


    public function fetchWeekyPublicSales($sale_code){
        $avaiability = DB::table('public_auction_sale_main')
                        ->where('sales_code', '=' ,$sale_code)
                        ->where('type','=','WEEKLY')
                        ->select('id')
                        ->first();

        $fetchData = array();

        if ($avaiability != NULL) {
            $fetchData =  DB::table('public_auction_sale_details')
                            ->join('reference_public_auction_sales','reference_public_auction_sales.id','=','public_auction_sale_details.reference_id')
                            ->where('public_auction_sale_details.public_auction_main_id','=',$avaiability->id)
                            ->select('public_auction_sale_details.*','reference_public_auction_sales.name AS refname')
                            ->get();
        }        

        return json_decode($fetchData);
    }//fetchWeekyPublicSales

    public function fetchMonthlyPublicSales($sale_code){
        $avaiability = DB::table('public_auction_sale_main')
                            ->where('sales_code', '=' ,$sale_code)
                            ->where('type','=','MONTHLY')
                            ->select('id')
                            ->first();

        $fetchData =  DB::table('public_auction_sale_details')
                        ->join('reference_public_auction_sales','reference_public_auction_sales.id','=','public_auction_sale_details.reference_id')
                        ->where('public_auction_sale_details.public_auction_main_id','=',$avaiability->id)
                        ->select('public_auction_sale_details.*','reference_public_auction_sales.name AS refname')
                        ->get();

        return json_decode($fetchData);
    }//fetchMonthlyPublicSales


    public function fetchNationWideDescriptions($sale_code){
        
        $fetchData = DB::table('nation_wide_tea_descriptions')
                        ->where('sales_code','=',$sale_code)
                        ->select('title','description','type')
                        ->get();

        return json_decode($fetchData);
    }//fetchNationWideDescriptions


    public function fetchTeaExports($sale_code){

        $avaiability = DB::table('sri_lanka_tea_export_main')
                                ->where('sales_code', '=' ,$sale_code)
                                ->select('id')
                                ->first();

       $fetchData = DB::table('srilankan_tea_exports_details')
                        ->leftjoin('sri_lanka_tea_export_main','sri_lanka_tea_export_main.id','=','srilankan_tea_exports_details.tea_export_main_id')
                        ->leftjoin('reference_srilankan_tea_exports','reference_srilankan_tea_exports.id','=','srilankan_tea_exports_details.reference_srilankan_tea_exports_id')
                        ->where('srilankan_tea_exports_details.tea_export_main_id','=', $avaiability->id)
                        ->where('sri_lanka_tea_export_main.sale_code','=', $sale_code)
                        ->select('srilankan_tea_exports_details.*','reference_srilankan_tea_exports.name AS refName','reference_srilankan_tea_exports.id AS refId')
                        ->get();

        return json_decode($fetchData);
    }//fetchTeaExports


    public function fetchMajorImporters($sale_code){
        
        // $avaiability = DB::table('major_importers_main')
        //                     ->where('sales_code', '=' ,$sale_code)
        //                     ->select('id')
        //                     ->first();

        $fetchData = DB::table('major_importers_main')
                            ->leftjoin('major_importers_details','major_importers_details.importers_main_id','=','major_importers_main.id')
                            ->leftjoin('import_countries','import_countries.id','=','major_importers_details.country_id')
                            ->where('major_importers_main.sales_code', '=' ,$sale_code)
                            ->select('major_importers_details.*','import_countries.name AS country')
                            ->get();

        return json_decode($fetchData);
    }


    public function fetchSriLankanTeaProduction($sale_code){

        $fetchData = DB::table('srilankan_tea_production_details')
                        ->where('sale_code','=',$sale_code)
                        ->get();

        return $fetchData;
    }//fetchSriLankanTeaProduction


    public function fetchAwaitingCatalogues($sale_code){
        
        $fetchData = DB::table('awaiting_catalogues')
                                ->leftjoin('reference_awaiting_catelogues', 'reference_awaiting_catelogues.id', '=', 'awaiting_catalogues.reference_awaiting_catalogue')
                                ->where('awaiting_catalogues.sale_code','=',$sale_code)
                                ->select('reference_awaiting_catelogues.catelogue_references','reference_awaiting_catelogues.code','reference_awaiting_catelogues.name AS refname','reference_awaiting_catelogues.id AS refID','awaiting_catalogues.*')
                                ->get();

        return json_decode($fetchData);
    }//fetchAwaitingCatalogues


    public function fetchWorldTeaDescriptions($sale_code){
        $fetchData = DB::table('tea_market_descriptions')
                        ->where('sales_code','=',$sale_code)
                        ->get();

        return json_decode($fetchData);
    }//fetchWorldTeaDescriptions


    public function fetchAwaiting_2($sale_code){
        
        $fetchData = DB::table('nation_wide_tea_descriptions')
                        ->where('sales_code','=',$sale_code)
                        ->select('title','description','type')
                        ->get();

        return json_decode($fetchData);
    }//fetchAwaiting_2
}
