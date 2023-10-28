<?php

namespace App\Http\Controllers;

use App\Http\Traits\DBOperationsTrait;
use App\Models\awaiting_catalogue_closure_details;
use App\Models\awaiting_catalogues;
use App\Models\awaiting_lots_and_qty;
use App\Models\awaiting_lots_qty_summary;
use App\Models\awaiting_sale_time;
use App\Models\awaiting_sales_main;
use App\Models\import_countries;
use App\Models\months;
use App\Models\order_of_sale_details;
use App\Models\reference_awaiting_catelogues;
use App\Models\reference_awaiting_lots_quantity;
use App\Models\sales_list;
use App\Models\vendors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\Promise\all;

class AwaitingSalesController extends Controller
{
    use DBOperationsTrait;

    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');  
            
            return $next($request);
        });
    }

    public function fetchAwaitingLotsAndQty($awaiting_sale_code){
        $awaitingLotsQtyDetails = DB::table('awaiting_lots_and_qty')
                        ->leftjoin('reference_awaiting_lots_quantity', 'reference_awaiting_lots_quantity.id', '=', 'awaiting_lots_and_qty.ref_id')
                        ->where('awaiting_lots_and_qty.sale_code','=',$awaiting_sale_code)
                        ->select('reference_awaiting_lots_quantity.name AS refName','reference_awaiting_lots_quantity.code AS refCode','reference_awaiting_lots_quantity.id AS refID','awaiting_lots_and_qty.*')
                        ->get();

        return $awaitingLotsQtyDetails;
    }

    
    public function fetchAwaitingCatalogueClosures($awaiting_sale_code){
        $clousersArray = array();
        $awaitingClosures = DB::table('awaiting_catalogue_closure_details')
                                    ->leftjoin('months', 'months.id', '=', 'awaiting_catalogue_closure_details.month')
                                    ->where('awaiting_catalogue_closure_details.sale_code','=',$awaiting_sale_code)
                                    ->select('months.name AS monthName','awaiting_catalogue_closure_details.*')
                                    ->get();

        if (count($awaitingClosures) > 0) {
            foreach ($awaitingClosures as $key => $value) {
                array_push($clousersArray,array(
                    'date_in_text'=> $value->days_in_text,
                    'monthName'=> $value->monthName,
                    'month'=> $value->month,
                    'year'=> $value->year,
                    'sale_number'=> $value->sale_number,
                    'small_description'=> $value->small_description,
                ));
            }
        } else {
            for ($i=0; $i < 3; $i++) { 
                array_push($clousersArray,array(
                    'date_in_text'=> '',
                    'monthName'=> '',
                    'month'=> '1',
                    'year'=> date('Y'),
                    'sale_number'=> '',
                    'small_description'=> '',
                ));
            }
        }                                    

        return $clousersArray;

    }//fetchAwaitingCatalogueClosures


    public function getAwaiting1(){        

        // fetch awiating lots and quantity
        $fetchReferences = $this->fetchData(new reference_awaiting_lots_quantity());

        $awaiting_sale_code = $this->getAwaitingSaleNumber($this->session_sale_code,1);

        // order of sales details
        $vendors = $this->fetchData(new vendors());  
        $orderOfSaleDetails = $this->fetchDataSetBySaleCode(new order_of_sale_details(), 'sale_code', $awaiting_sale_code);
                       
        $fetchAwaitingLotsQty = $this->fetchAwaitingLotsAndQty($awaiting_sale_code);        
        
        $saleReportDetails = $this->fetchDetailsBySalesCode(new sales_list(),'sales_code',$awaiting_sale_code);

        $awaitingSaleTimeSlots = $this->fetchDataSetBySaleCode(new awaiting_sale_time(),'sale_code',$awaiting_sale_code);
        
        
        $saleReportDay_1 = date('Y-m-d');
        $saleReportDay_2 = date('Y-m-d');
        if ($saleReportDetails != NULL) {
            $saleReportDay_1 = date('Y-m-d',strtotime($saleReportDetails->report_day_one));
            $saleReportDay_2 = date('Y-m-d',strtotime($saleReportDetails->report_day_two));
        }
        
        
        $refCatalogDetails = $this->fetchData(new reference_awaiting_catelogues());
        
        // Fetch awaiting catalogues
        // $cateloguDetails = $this->fetchDataSetBySaleCode(new awaiting_catalogues(),'sale_code',$awaiting_sale_code);
        $cateloguDetails = DB::table('awaiting_catalogues')
                                ->leftjoin('reference_awaiting_catelogues', 'reference_awaiting_catelogues.id', '=', 'awaiting_catalogues.reference_awaiting_catalogue')
                                ->where('awaiting_catalogues.sale_code','=',$awaiting_sale_code)
                                ->select('reference_awaiting_catelogues.catelogue_references','reference_awaiting_catelogues.code','reference_awaiting_catelogues.name AS refname','reference_awaiting_catelogues.id AS refID','awaiting_catalogues.*')
                                ->get();
                
        $catalogueArray = array();
        $num_packages = 0;
        $ctc = 0;

        if (count($cateloguDetails) > 0) {
            
            foreach ($cateloguDetails as $key => $singleCatg) {
                if ($key == 1) {
                    $num_packages = $singleCatg->no_of_packages;
                    $ctc = $singleCatg->ctc;
                }
                array_push($catalogueArray,array(
                    'code'=>$singleCatg->code,
                    'values'=>json_decode($singleCatg->catelogue_values),
                    'references'=>json_decode($singleCatg->catelogue_references),
                    'date'=>date('Y-m-d',strtotime($singleCatg->date)),
                    'name'=>$singleCatg->refname
                ));
            }
        } else {
            
            foreach ($refCatalogDetails as $key => $singleRefCatg) {
                
                $values = array();
                for ($i=0; $i < count(json_decode($singleRefCatg->catelogue_references)); $i++) { 
                    $values[$i] = '';
                }
                array_push($catalogueArray,array(
                    'code'=>$singleRefCatg->code,
                    'values'=>$values,
                    'references'=>json_decode($singleRefCatg->catelogue_references),
                    'date'=>date('Y-m-d',strtotime(date('Y-m-d'))),
                    'name'=>$singleRefCatg->name
                ));
            }
        }        

        
        // $lowGrown = $refCatalogDetails->;  
        foreach ($refCatalogDetails as $key => $value) {
            if ($value->code == 'LOW_GROWN_CATALG') {
                $low_catg_references = json_decode($value->catelogue_references);
            }
            if ($value->code == 'OTHER_MAIN_CATALG') {
                $other_main_catg_references = json_decode($value->catelogue_references);
            }            
        }      

                
        return view('/tea-statistics/awaitingSales_1',[
                                                        'awaiting_sale_code' => $awaiting_sale_code,
                                                        'orderOfSaleDetails'=>$orderOfSaleDetails,
                                                        'vendors'=>$vendors,
                                                        'saleReportDay_1'=>$saleReportDay_1,
                                                        'saleReportDay_2'=>$saleReportDay_2,
                                                        'references'=>$fetchReferences,
                                                        'fetchAwaitingLotsQty'=>$fetchAwaitingLotsQty,
                                                        'sale_code'=>$this->session_sale_code,
                                                        'awaitingSaleTimeSlots'=>$awaitingSaleTimeSlots,
                                                        'low_references'=>$low_catg_references,
                                                        'catalogDetails'=>$catalogueArray,
                                                        'other_main_references'=>$other_main_catg_references,
                                                        'no_of_packages'=>$num_packages,
                                                        'ctc'=>$ctc,
                                                    ]);
    }//getAwaiting1


    public function getAwaiting2(){
        $fetchReferences = $this->fetchData(new reference_awaiting_lots_quantity());

        $months = $this->fetchData(new months());
        $yearList = $this->fetchYearList();
        
        $awaiting_sale_code = $this->getAwaitingSaleNumber($this->session_sale_code,2);
        $saleReportDetails = $this->fetchDetailsBySalesCode(new sales_list(),'sales_code',$awaiting_sale_code);
        
        $saleReportDay_1 = date('Y-m-d');
        $saleReportDay_2 = date('Y-m-d');
        if ($saleReportDetails != NULL) {
            $saleReportDay_1 = date('Y-m-d',strtotime($saleReportDetails->report_day_one));
            $saleReportDay_2 = date('Y-m-d',strtotime($saleReportDetails->report_day_two));
        }
                        
        $fetchAwaitingLotsQty = $this->fetchAwaitingLotsAndQty($awaiting_sale_code);

        $fetchAwaitingCatalogueClosures = $this->fetchAwaitingCatalogueClosures($awaiting_sale_code);
        
        $refCatalogDetails = $this->fetchData(new reference_awaiting_catelogues());
        
        // Fetch awaiting catalogues
        // $cateloguDetails = $this->fetchDataSetBySaleCode(new awaiting_catalogues(),'sale_code',$awaiting_sale_code);
        $cateloguDetails = DB::table('awaiting_catalogues')
                                ->leftjoin('reference_awaiting_catelogues', 'reference_awaiting_catelogues.id', '=', 'awaiting_catalogues.reference_awaiting_catalogue')
                                ->where('awaiting_catalogues.sale_code','=',$awaiting_sale_code)
                                ->select('reference_awaiting_catelogues.catelogue_references','reference_awaiting_catelogues.code','reference_awaiting_catelogues.name AS refname','reference_awaiting_catelogues.id AS refID','awaiting_catalogues.*')
                                ->get();
        
        $catalogueArray = array();
        $num_packages = 0;
        $ctc = 0;

        if (count($cateloguDetails) > 0) {
            foreach ($cateloguDetails as $key => $singleCatg) {
                if ($key == 1) {
                    $num_packages = $singleCatg->no_of_packages;
                    $ctc = $singleCatg->ctc;
                }
                array_push($catalogueArray,array(
                    'code'=>$singleCatg->code,
                    'values'=>json_decode($singleCatg->catelogue_values),
                    'references'=>json_decode($singleCatg->catelogue_references),
                    'date'=>date('Y-m-d',strtotime($singleCatg->date)),
                    'name'=>$singleCatg->refname
                ));
            }
        } else {
            foreach ($refCatalogDetails as $key => $singleRefCatg) {
                $values = array();
                for ($i=0; $i < count(json_decode($singleRefCatg->catelogue_references)); $i++) { 
                    $values[$i] = '';
                }
                array_push($catalogueArray,array(
                    'code'=>$singleRefCatg->code,
                    'values'=>$values,
                    'references'=>json_decode($singleRefCatg->catelogue_references),
                    'date'=>date('Y-m-d',strtotime(date('Y-m-d'))),
                    'name'=>$singleRefCatg->name
                ));
            }
        }        
        
        
        // $lowGrown = $refCatalogDetails->;  
        foreach ($refCatalogDetails as $key => $value) {
            if ($value->code == 'LOW_GROWN_CATALG') {
                $low_catg_references = json_decode($value->catelogue_references);
            }
            if ($value->code == 'OTHER_MAIN_CATALG') {
                $other_main_catg_references = json_decode($value->catelogue_references);
            }            
        }      

                
        return view('/tea-statistics/awaitingSales_2',[
                                                        'awaiting_sale_code' => $awaiting_sale_code,
                                                        'saleReportDay_1'=>$saleReportDay_1,
                                                        'saleReportDay_2'=>$saleReportDay_2,
                                                        'references'=>$fetchReferences,
                                                        'fetchAwaitingLotsQty'=>$fetchAwaitingLotsQty,
                                                        'sale_code'=>$this->session_sale_code,
                                                        'low_references'=>$low_catg_references,
                                                        'catalogDetails'=>$catalogueArray,
                                                        'other_main_references'=>$other_main_catg_references,
                                                        'no_of_packages'=>$num_packages,
                                                        'ctc'=>$ctc,
                                                        'awaitingCatalogueClosures'=>$fetchAwaitingCatalogueClosures,
                                                        'months'=>$months,
                                                        'yearList'=>$yearList
                                                    ]);    
    }

   
    // // ------------------------------manipulate lots and quantity----------------------

    public function createAwaitingLotsAndQty($lots, $quantity,$date,$awaiting_sale_code,$sale_no){
        
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;

        $fetchReferences = $this->fetchData(new reference_awaiting_lots_quantity());

        $sales_details = $this->fetchDetailsBySalesCode(new sales_list(),'sales_code',$awaiting_sale_code);
        
        if ($sales_details == NULL) {
            
            $report = new sales_list();

            $latest_id = DB::table('sales_list')->orderBy('sales_id', 'desc')->value('sales_id');
            $sales_id = $latest_id+1;

            $report->sales_id = $sales_id;
            $report->sales_code = $awaiting_sale_code;
            $report->sales_no = $sale_no;
            $report->report_day_one = $date;

            $result = $report->save();
        }

        $lotssumry = 0;
        $reprintlotsumry = 0;
        $quantitysumry = 0;
        $reprintQtysumry = 0;        

        foreach ($fetchReferences as $key => $ref) {
            $lot = NULL;
            $qty = NULL;
            if ($lots[$key] != NULL) {
                $lot =  floatval(preg_replace('/[^\d.]/', '', $lots[$key]));
            }

            if ($quantity[$key] != NULL) {
                $qty =  floatval(preg_replace('/[^\d.]/', '', $quantity[$key]));
            }

            // Enter lots and Qty summary details
            if (($key == 8) & ($ref->code == 'TOTAL')) {
                $lotssumry = $lot;
                $quantitysumry = $qty;
            }

            if (($key == 9) & ($ref->code == 'REPRINTS')) {
                $reprintlotsumry = $lot;
                $reprintQtysumry = $qty;
            }

            $result = awaiting_lots_and_qty::create([
                'sale_code' => $awaiting_sale_code,
                'ref_id' => $ref->id,
                'lots_value' => $lot,
                'quantity' => $qty,
            ]);
        }

        $awaitingSummary = new awaiting_lots_qty_summary();
        $awaitingSummary->sales_code = $awaiting_sale_code;
        $awaitingSummary->lots = $lotssumry;
        $awaitingSummary->reprints_lots = $reprintlotsumry;
        $awaitingSummary->quantity = $quantitysumry;
        $awaitingSummary->reprints_qty = $reprintQtysumry;
        $addSummary = $awaitingSummary->save();

        if ($result) {
            $message = 'Awaiting Sales Lots and Quantities added successfully!';
            $value = 1;
            
            $redirect = '/overall-market';
        } else {
            $message = 'Awaiting Sales Lots and Quantities are not added!';
        }
        
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }//createAwaitingLotsAndQty


    public function updateAwaitingLotsAndQty($lots, $quantity,$date,$awaiting_sale_code,$sale_no){
        
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;
        
        $fetchReferences = $this->fetchData(new reference_awaiting_lots_quantity());
        $sales_details = $this->fetchDetailsBySalesCode(new sales_list(),'sales_code',$this->session_sale_code);
        
        $lotssumry = 0;
        $reprintlotsumry = 0;
        $quantitysumry = 0;
        $reprintQtysumry = 0;  

        foreach ($fetchReferences as $key => $ref) {

            $awaitingLotsQty = awaiting_lots_and_qty::select('id','lots_value','quantity')
                        ->where('sale_code', '=',$awaiting_sale_code)
                        ->where('ref_id', '=', $ref->id)
                        ->first();

            $lot = NULL;
            $qty = NULL;
            if ($lots[$key] != NULL) {
                $lot =  floatval(preg_replace('/[^\d.]/', '', $lots[$key]));
            }

            if ($quantity[$key] != NULL) {
                $qty =  floatval(preg_replace('/[^\d.]/', '', $quantity[$key]));
            }

            // Enter lots and Qty summary details
            if (($key == 8) & ($ref->code == 'TOTAL')) {
                $lotssumry = $lot;
                $quantitysumry = $qty;
            }

            if (($key == 9) & ($ref->code == 'REPRINTS')) {
                $reprintlotsumry = $lot;
                $reprintQtysumry = $qty;
            }

            $awaitingLotsQty->lots_value = $lot;
            $awaitingLotsQty->quantity = $qty;
            $result = $awaitingLotsQty->save();            
        }

        $awaitingSummary = new awaiting_lots_qty_summary();
        $awaitingSummary->sales_code = $awaiting_sale_code;
        $awaitingSummary->lots = $lotssumry;
        $awaitingSummary->reprints_lots = $reprintlotsumry;
        $awaitingSummary->quantity = $quantitysumry;
        $awaitingSummary->reprints_qty = $reprintQtysumry;
        $addSummary = $awaitingSummary->save();
        
        if ($result) {
            $message = 'Awaiting Sales Lots and Quantities updated successfully!';
            $value = 1;
            
        } else {
            $message = 'Awaiting Sales Lots and Quantities are not updated!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }//updateAwaitingLotsAndQty


    public function manipulateAwaitingLotsQtyDetails(Request $request){
        $status = array();

        $sale_code = $this->session_sale_code;
        $saleNo = '';
        
        if ($request->sale_code != 'CURRENT_SALE') {
            $sale_code = $request->sale_code;  
            $saleNo = $request->sale_no;          
        }else {
            $seperatedSaleDetails = $this->seperateSaleCodeDetails($sale_code);
            $saleNo = $seperatedSaleDetails['number'];
        }
        
        // $this->getAwaitingSaleNumber($this->session_sale_code,1);
        $availability = $this->fetchAwaitingLotsAndQty($sale_code);
        
        $lots_value = $request->lots_value;
        $quantity = $request->quantity;
        $scheduled_date = $request->sale_scheduled_date;        

        if (count($availability) == '0') {
            $status = $this->createAwaitingLotsAndQty($lots_value, $quantity,$scheduled_date,$sale_code,$saleNo);
        } else {
            $status = $this->updateAwaitingLotsAndQty($lots_value, $quantity,$scheduled_date,$sale_code,$saleNo);
        }
        
        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);
    }//manipulateAwaitingLotsQtyDetails


    // ----------------------Awaiting catelogue and package details---------------------

    public function createCatalogues($details){
        
        $message = '';
        $value = 0;
        $redirect = '';
        $res = 0;       
        
        $references = $this->fetchData(new reference_awaiting_catelogues());
        $low = array();
        $main = array();
        foreach ($details['values'] as $inner => $value) {
            if (($inner == 0) | ($inner == 1) | ($inner == 2) ) {
                $low[] = $value;
            } else {
                $main[] = $value;
            }                
        }         
        
        
        $sales_details = $this->fetchDetailsBySalesCode(new sales_list(),'sales_code',$details['sale_code']);
        
        if ($sales_details == NULL) {
            
            $report = new sales_list();
            
            $latest_id = DB::table('sales_list')->orderBy('sales_id', 'desc')->value('sales_id');
            $sales_id = $latest_id+1;

            $seperateSaleCodeDetails = $this->seperateSaleCodeDetails($details['sale_code']);

            $report->sales_id = $sales_id;
            $report->sales_code = $details['sale_code'];
            $report->sales_no = $seperateSaleCodeDetails['number'];
            $report->report_day_one = date('Y-m-d');

            $result = $report->save();
        }
       
        foreach ($references as $key => $singleRef) {
            $type = 'LOWGROWN';
            // print_r($count[0]);
            $values = json_encode($low);          
           
            if ($details['code'][$key] == 'OTHER_MAIN_CATALG') {
                $type = 'MAINSALE';
                $values = json_encode($main);
            }

            $res = awaiting_catalogues::create([
                'sale_code' => $details['sale_code'],
                'type' => $type,
                'reference_awaiting_catalogue' => $singleRef->id,
                'catelogue_values' => $values,
                'date'=>$details['date'][$key],
                'no_of_packages' => $details['no_of_pkgs'],
                'ctc' => $details['ctc'],
            ]);
        }
    

        if ($res) {
            $message = 'Awaiting Details added successfully!';
            $value = 1;        
            
        } else {
            $message = 'Awaiting Details are not added!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );      
    }//createCatalogues


    public function updateCatalogues($details){
        $message = '';
        $value = 0;
        $redirect = '';
        $res = 0;        
        
        $data = $this->fetchDataSetBySaleCode(new awaiting_catalogues(),'sale_code',$details['sale_code']);
        $sales_details = $this->fetchDetailsBySalesCode(new sales_list(),'sales_code',$details['sale_code']);
        
        if ($sales_details == NULL) {
            
            $report = new sales_list();
            
            $latest_id = DB::table('sales_list')->orderBy('sales_id', 'desc')->value('sales_id');
            $sales_id = $latest_id+1;

            $seperateSaleCodeDetails = $this->seperateSaleCodeDetails($details['sale_code']);

            $report->sales_id = $sales_id;
            $report->sales_code = $details['sale_code'];
            $report->sales_no = $seperateSaleCodeDetails['number'];
            $report->report_day_one = date('Y-m-d');

            $result = $report->save();
        }

        if ($data != NULL) {
            foreach ($data as $key => $value) {
                $res = $value->delete(); 
            }
        }

        $references = $this->fetchData(new reference_awaiting_catelogues());
       
        $low = array();
        $main = array();
        foreach ($details['values'] as $inner => $value) {
            if (($inner == 0) | ($inner == 1) | ($inner == 2) ) {
                $low[] = $value;
            } else {
                $main[] = $value;
            }                
        }           
       
        foreach ($references as $key => $singleRef) {
            $type = 'LOWGROWN';
            // print_r($count[0]);
            $values = json_encode($low);          
           
            if ($details['code'][$key] == 'OTHER_MAIN_CATALG') {
                $type = 'MAINSALE';
                $values = json_encode($main);
            }
            
            $res = awaiting_catalogues::create([
                'sale_code' => $details['sale_code'],
                'type' => $type,
                'reference_awaiting_catalogue' => $singleRef->id,
                'catelogue_values' => $values,
                'date'=>$details['date'][$key],
                'no_of_packages' => $details['no_of_pkgs'],
                'ctc' => $details['ctc'],
            ]);
        }

        if ($res) {
            $message = 'Awaiting Details updated successfully!';
            $value = 1;        
            
        } else {
            $message = 'Awaiting Details are not updated!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );      
    }//updateCatalogues

        
    public function manipulateAwaitingCatelogues(Request $request){
        $status = array();     
        $value = $request->value;
        
        $day_one_elevation_name = $request->day_one_elevation_name;
        $day_one_time = $request->day_one_time;

        $day_two_elevation = $request->day_two_elevation;
        $day_two_time = $request->day_two_time;

        // $approx_time_day_one = $this->approx_time_day_one;
        // $approx_time_day_two = $request->approx_time_day_two;        
        
        $availability = $this->fetchDetailsBySalesCode(new awaiting_catalogues(),'sale_code',$request->sale_code);
        
        if ($availability == NULL) {
            $status = $this->createCatalogues(array('sale_code'=>$request->sale_code,'values'=>$value,'date'=>$request->catg_date,'code'=>$request->code,'no_of_pkgs'=>$request->no_of_pkgs,'ctc'=>$request->ctc,'approx_time_day_one'=>$day_two_elevation));
        } else {
            $status = $this->updateCatalogues(array('sale_code'=>$request->sale_code,'values'=>$value,'date'=>$request->catg_date,'code'=>$request->code,'no_of_pkgs'=>$request->no_of_pkgs,'ctc'=>$request->ctc,
                                                    'day_two_elevation'=>$day_two_elevation,'day_two_time'=>$day_two_time));
        }    
        
        
        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);
    }//manipulateAwaiting




    public function createAwaitingTimeSlots($detailsArray){
        $message = 'Details are not added';
        $value = 0;
        $redirect = '';
        $res1 = $res2 = 0;             

        $sales_details = $this->fetchDetailsBySalesCode(new sales_list(),'sales_code',$detailsArray['sale_code']);
        
        if ($sales_details == NULL) {
            
            $report = new sales_list();
            
            $latest_id = DB::table('sales_list')->orderBy('sales_id', 'desc')->value('sales_id');
            $sales_id = $latest_id+1;

            $seperateSaleCodeDetails = $this->seperateSaleCodeDetails($detailsArray['sale_code']);

            $report->sales_id = $sales_id;
            $report->sales_code = $detailsArray['sale_code'];
            $report->sales_no = $seperateSaleCodeDetails['number'];
            $report->report_day_one = date('Y-m-d');

            $result = $report->save();
        }
               
        foreach ($detailsArray['day_one_elevation'] as $key => $value) {
                        
            $res1 = awaiting_sale_time::create([
                'sale_code' => $detailsArray['sale_code'],
                'type' => 'DAY_1',
                'date' => $detailsArray['day_1'],
                'elevation' => $value,
                'time'=>$detailsArray['day_one_time'][$key],
            ]);
        }
        
        foreach ($detailsArray['day_two_elevation'] as $key => $value) {
                        
            $res2 = awaiting_sale_time::create([
                'sale_code' => $detailsArray['sale_code'],
                'type' => 'DAY_2',
                'date' => $detailsArray['day_2'],
                'elevation' => $value,
                'time'=>$detailsArray['day_two_time'][$key],
            ]);
        }
    

        if ($res1) {
            $message = 'Awaiting Time Slots added successfully!';
            $value = 1;        
            
        } else {
            $message = 'Awaiting Time Slots are not added!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );      
    }//createAwaitingTimeSlots


    public function updateAwaitingTimeSlots($detailsArray){
        $message = 'Details are not updated!';
        $value = 0;
        $redirect = '';
        $res1 = $res2 = 0;    
        
        $sales_details = $this->fetchDetailsBySalesCode(new sales_list(),'sales_code',$detailsArray['sale_code']);
        
        if ($sales_details == NULL) {
            
            $report = new sales_list();
            
            $latest_id = DB::table('sales_list')->orderBy('sales_id', 'desc')->value('sales_id');
            $sales_id = $latest_id+1;

            $seperateSaleCodeDetails = $this->seperateSaleCodeDetails($detailsArray['sale_code']);

            $report->sales_id = $sales_id;
            $report->sales_code = $detailsArray['sale_code'];
            $report->sales_no = $seperateSaleCodeDetails['number'];
            $report->report_day_one = date('Y-m-d');

            $result = $report->save();
        }

        $deleteDetails = DB::table('awaiting_sale_time')
                            ->where('sale_code', '=' ,$detailsArray['sale_code'])
                            ->delete();

        if ($deleteDetails) {
            foreach ($detailsArray['day_one_elevation'] as $key => $value) {
                        
                $res1 = awaiting_sale_time::create([
                    'sale_code' => $detailsArray['sale_code'],
                    'type' => 'DAY_1',
                    'date' => $detailsArray['day_1'],
                    'elevation' => $value,
                    'time'=>$detailsArray['day_one_time'][$key],
                ]);
            }
            
            foreach ($detailsArray['day_two_elevation'] as $key => $value) {
                            
                $res2 = awaiting_sale_time::create([
                    'sale_code' => $detailsArray['sale_code'],
                    'type' => 'DAY_2',
                    'date' => $detailsArray['day_2'],
                    'elevation' => $value,
                    'time'=>$detailsArray['day_two_time'][$key],
                ]);
            }
        
    
            if ($res1 ) {
                $message = 'Awaiting Time Slots updated successfully!';
                $value = 1;        
                
            } else {
                $message = 'Awaiting Time Slots are not updated!';
            }
        }   
      
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );      
    }//updateAwaitingTimeSlots


    // -------------------------Awaiting time slots------------------------------------------
    public function manipulateAwaitingtimeSlots(Request $request){
        $status = array();     
        
        $awaiting_sale_code = $request->awaiting_sale_code;
        $approx_time_day_one = $request->approx_time_day_one;
        $day_one_elevation = $request->day_one_elevation;
        $day_one_time = $request->day_one_time;

        $approx_time_day_two = $request->approx_time_day_two;
        $day_two_elevation = $request->day_two_elevation;
        $day_two_time = $request->day_two_time;
        
        $availability = $this->fetchDataSetBySaleCode(new awaiting_sale_time(),'sale_code',$request->awaiting_sale_code);
        $detailsArray = array('sale_code'=>$awaiting_sale_code,
                                'day_1'=>$approx_time_day_one,
                                'day_one_elevation'=>$day_one_elevation,
                                'day_one_time'=>$day_one_time,
                                'day_2'=>$approx_time_day_two,
                                'day_two_elevation'=>$day_two_elevation,
                                'day_two_time'=>$day_two_time
                            );

        if (count($availability) == 0) {
            $status = $this->createAwaitingTimeSlots($detailsArray);
            
        } else {
            $status = $this->updateAwaitingTimeSlots($detailsArray);
            
        }            
        
        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);
    }//manipulateAwaitingtimeSlots


    public function createCatalogClosures($detailsArray){
        $message = 'Details are not added';
        $value = 0;
        $redirect = '';
        $res1 = $res2 = 0;             

        $sales_details = $this->fetchDetailsBySalesCode(new sales_list(),'sales_code',$detailsArray['sale_code']);
        
        if ($sales_details == NULL) {
            
            $report = new sales_list();
            
            $latest_id = DB::table('sales_list')->orderBy('sales_id', 'desc')->value('sales_id');
            $sales_id = $latest_id+1;

            $seperateSaleCodeDetails = $this->seperateSaleCodeDetails($detailsArray['sale_code']);

            $report->sales_id = $sales_id;
            $report->sales_code = $detailsArray['sale_code'];
            $report->sales_no = $seperateSaleCodeDetails['number'];
            $report->report_day_one = date('Y-m-d');

            $result = $report->save();
        }
               
        foreach ($detailsArray['month'] as $key => $value) {
                        
            $res1 = awaiting_catalogue_closure_details::create([
                'sale_code' => $detailsArray['sale_code'],
                'days_in_text' => $detailsArray['date_in_text'][$key],
                'month' => $value,
                'year' => $detailsArray['year'][$key],
                'sale_number'=>$detailsArray['sale_no'][$key],
                'small_description'=>$detailsArray['desc'][$key],
            ]);
        }            

        if ($res1) {
            $message = 'Awaiting Catalogue Closure added successfully!';
            $value = 1;        
            
        } else {
            $message = 'Awaiting Catalogue Closures not added!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );     
    }//createCatalogClosures


    public function updateCatalogClosures($detailsArray){       
        $message = 'Details are not updated!';
        $value = 0;
        $redirect = '';
        $res1 = $res2 = 0;    
        
        $deleteDetails = DB::table('awaiting_catalogue_closure_details')
                            ->where('sale_code', '=' ,$detailsArray['sale_code'])
                            ->delete();

        if ($deleteDetails) {
            foreach ($detailsArray['month'] as $key => $value) {
                        
                $res1 = awaiting_catalogue_closure_details::create([
                    'sale_code' => $detailsArray['sale_code'],
                    'days_in_text' => $detailsArray['date_in_text'][$key],
                    'month' => $value,
                    'year' => $detailsArray['year'][$key],
                    'sale_number'=>$detailsArray['sale_no'][$key],
                    'small_description'=>$detailsArray['desc'][$key],
                ]);
            }
    
            if ($res1 ) {
                $message = 'Awaiting Catalogue Closure updated successfully!';
                $value = 1;        
                
            } else {
                $message = 'Awaiting Catalogue Closures not updated!';
            }
        }   
      
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );      
    }//updateCatalogClosures


    // ---------------------------Awaiting Catalogue closures---------------------------------
    public function manipulateCatelogueClosureDetails(Request $request){

        $status = array();     
        
        $date_in_text = $request->date_in_text;
        $month = $request->month;
        $year = $request->year;
        $sale_no = $request->sale_no;
        $desc = $request->desc;
        
        $availability = $this->fetchDataSetBySaleCode(new awaiting_catalogue_closure_details(),'sale_code',$request->awaiting_sale_code);
        $detailsArray = array(
                                'sale_code'=>$request->awaiting_sale_code,
                                'date_in_text'=>$date_in_text,
                                'month'=>$month,
                                'year'=>$year,
                                'sale_no'=>$sale_no,
                                'desc'=>$desc,
                            );

        if (count($availability) == 0) {
            $status = $this->createCatalogClosures($detailsArray);
            
        } else {
            $status = $this->updateCatalogClosures($detailsArray);
            
        }      
         
        return json_encode(array(
            'message' => 'Closure details updated successfully!',
            'result' => 1,
            'redirect'=> '' 
         ), 200);
    }//manipulateCatelogueClosureDetails
}
