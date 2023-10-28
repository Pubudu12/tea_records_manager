<?php

namespace App\Http\Controllers\teaStatistics;

use App\Http\Controllers\Controller;
use App\Http\Traits\DBOperationsTrait;
use App\Models\public_auction_sale_details;
use App\Models\public_auction_sale_main;
use App\Models\public_auction_sale_monthly;
use App\Models\public_auction_sale_weekly;
use App\Models\reference_public_auction_sales;
use App\Models\sales_list;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicAuctionSalesController extends Controller
{
    use DBOperationsTrait;

    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');  
            
            return $next($request);
        });
    }


    public function fetchPreviousYearSaleData($salecode){

        $prevYearSaleTotalValues = array();

        $currentData = DB::table('sales_list')
                            ->where('sales_code','=' ,$salecode)
                            ->select('year','sales_no')
                            ->first();

        if ($currentData != NULL) {
            $currentYear = $currentData->year;
            $currentSaleNo = $currentData->sales_no;

            $prevYear = (int)$currentYear - 1;
            $prevSaleCode = $prevYear.'-'.$currentSaleNo;
            $prevYearSaleTotalValues = DB::table('public_auction_sale_main')
                                                ->leftjoin('public_auction_sale_details','public_auction_sale_details.public_auction_main_id','=','public_auction_sale_main.id')
                                                ->where('sales_code','=' ,$prevSaleCode)
                                                ->select('public_auction_sale_details.price_lkr','public_auction_sale_details.todate_price_lkr',
                                                        'public_auction_sale_details.price_usd','public_auction_sale_details.todate_price_usd')
                                                ->get();
        }             

        return $prevYearSaleTotalValues;
    }//fetchPreviousYearSaleData
    

    public function getWeeklyPublicAuctionSales(){
        $references = $this->fetchData(new reference_public_auction_sales());
        $status = 0;
        $values = array();        

        $previousSalesCode = $this->getPreviousSalesCode($this->session_sale_code);
        
        $previousData = $this->fetchPreviousYearSaleData($previousSalesCode['sale_code']);

        $currentData = DB::table('sales_list')
                            ->where('sales_code','=' ,$previousSalesCode['sale_code'])
                            ->select('year','month')
                            ->first();

                            print_r('ncjkdncjdnjk');

        $month = $currentData->month;
        $year = $currentData->year;       
        $lastYear = ((int)$year) - 1;
        
        if ($previousSalesCode['number'] == 0) {
            // $dataSet = DB::table('sales_list')
            //                 ->where('year', '=' ,$previousSalesCode['year'])
            //                 ->select('public_auction_sale_details.*','reference_public_auction_sales.*')
            //                 ->first();
        }

        $avaiability = DB::table('public_auction_sale_main')
                            ->where('sales_code', '=' ,$previousSalesCode['sale_code'])
                            ->where('type','=','WEEKLY')
                            ->first();
        $source_1 = '';  
        $source_2 = '' ;  
        if ($avaiability != NULL) {
            
            $auction_main_details =  DB::table('public_auction_sale_details')
                                        ->join('reference_public_auction_sales','reference_public_auction_sales.id','=','public_auction_sale_details.reference_id')
                                        ->where('public_auction_sale_details.public_auction_main_id','=',$avaiability->id)
                                        ->select('public_auction_sale_details.*','reference_public_auction_sales.name AS refname')
                                        ->get();

            foreach ($auction_main_details as $key => $singleValue) {
                
                $price_lkr = number_format($singleValue->price_lkr,2);
                $tprince = number_format($singleValue->todate_price_lkr,2);
                if ($singleValue->price_lkr == NULL) {                    
                    $price_lkr = NULL;
                }

                if ($singleValue->todate_price_lkr == NULL) {
                    $tprince = NULL;
                }
                array_push($values,array(
                    'price_lkr'=>$price_lkr,
                    'lkr_status'=>$singleValue->lkr_status,
                    'lastYear_price_lkr'=> (count($previousData) > 0) ? $previousData[$key]->price_lkr:'',
                    'lastYear_todate_price_lkr'=> (count($previousData) > 0) ? $previousData[$key]->todate_price_lkr:'',
                    'todate_price_lkr'=>$tprince,
                    'todate_lkr_status'=>$singleValue->todate_lkr_status,
                    'id'=>$singleValue->reference_id,
                    'type'=>'',
                    'name'=>$singleValue->refname,
                ));
               
            }            
            $status = 1;   
            $source_1 = $avaiability->source_1;  
            $source_2 = $avaiability->source_2;   
        } else {
            foreach ($references as $key => $value) {
                array_push($values,array(
                    'price_lkr'=>'',
                    'lkr_status'=>'NO',
                    'todate_price_lkr'=>'',
                    'todate_lkr_status'=>'NO',
                    'lastYear_price_lkr'=> (count($previousData) > 0) ? $previousData[$key]->price_lkr:'',
                    'lastYear_todate_price_lkr'=> (count($previousData) > 0) ? $previousData[$key]->todate_price_lkr:'',
                    'id'=>$value->id,
                    'type'=>$value->type,
                    'name'=>$value->name,
                ));
            }  
        }    
        
        return view('tea-statistics/salesAverageWeekly',['weeklySalesAverageDetails'=>$references,'sale_code'=>$previousSalesCode['sale_code'],
                                                        'source_1'=>$source_1,'source_2'=>$source_2,
                                                        'status'=>$status,'values'=>$values,
                                                    'currentYear'=>$year,'lastYear'=>$lastYear]);
    }//getWeeklyPublicAuctionSales


    public function getMonthlyPublicAuctionSales(){
        $references = $this->fetchData(new reference_public_auction_sales());
        $status = 0; 
        $saleDetails = DB::table('sales_list')
                            ->leftjoin('months','months.id','=','sales_list.month')
                            ->where('sales_code', '=' ,$this->session_sale_code)
                            ->select('months.name','sales_list.year')
                            ->first();
        $values = array();

        $previousSalesCode = $this->getPreviousSalesCode($this->session_sale_code);
        
        $previousData = $this->fetchPreviousYearSaleData($previousSalesCode['sale_code']);

        $currentData = DB::table('sales_list')
                            ->where('sales_code','=' ,$previousSalesCode['sale_code'])
                            ->select('year','month')
                            ->first();

        $month = $currentData->month;
        $year = $currentData->year;       
        $lastYear = ((int)$year) - 1;

        $avaiability = DB::table('public_auction_sale_main')
                            ->where('sales_code', '=' ,$previousSalesCode['sale_code'])
                            ->where('type','=','MONTHLY')
                            ->first();
        $source_1 = '';  
        $source_2 = '';  

        if ($avaiability != NULL) {
            
            $auction_main_details =  DB::table('public_auction_sale_details')
                                        ->join('reference_public_auction_sales','reference_public_auction_sales.id','=','public_auction_sale_details.reference_id')
                                        ->where('public_auction_sale_details.public_auction_main_id','=',$avaiability->id)
                                        ->select('public_auction_sale_details.*','reference_public_auction_sales.name AS refname')
                                        ->get();

            foreach ($auction_main_details as $key => $singleValue) {
                
                $price_lkr = number_format($singleValue->price_lkr,2);
                $tprince = number_format($singleValue->todate_price_lkr,2);
                if ($singleValue->price_lkr == NULL) {                    
                    $price_lkr = NULL;
                }

                if ($singleValue->todate_price_lkr == NULL) {
                    $tprince = NULL;
                }
                array_push($values,array(
                    'price_lkr'=>$price_lkr,
                    'lkr_status'=>$singleValue->lkr_status,
                    'todate_price_lkr'=>$tprince,
                    'lastYear_price_lkr'=> (count($previousData) > 0) ? $previousData[$key]->price_lkr:'',
                    'lastYear_todate_price_lkr'=> (count($previousData) > 0) ? $previousData[$key]->todate_price_lkr:'',
                    'todate_lkr_status'=>$singleValue->todate_lkr_status,
                    'id'=>$singleValue->reference_id,
                    'type'=>'',
                    'name'=>$singleValue->refname,
                ));
            }      
            $status = 1;   
            $source_1 = $avaiability->source_1;  
            $source_2 = $avaiability->source_2;          
        } else {
            foreach ($references as $key => $value) {
                array_push($values,array(
                    'price_lkr'=>'',
                    'lkr_status'=>'NO',
                    'todate_price_lkr'=>'',
                    'todate_lkr_status'=>'NO',
                    'lastYear_price_lkr'=> (count($previousData) > 0) ? $previousData[$key]->price_lkr:'',
                    'lastYear_todate_price_lkr'=> (count($previousData) > 0) ? $previousData[$key]->todate_price_lkr:'',
                    'id'=>$value->id,
                    'type'=>$value->type,
                    'name'=>$value->name,
                ));
            }                        
        }       
        
        return view('tea-statistics/salesAverageMonthly',['weeklySalesAverageDetails'=>$references,'sale_code'=>$previousSalesCode['sale_code'],
                                                            'source_1'=>$source_1,'source_2'=>$source_2,
                                                            'status'=>$status,'values'=>$values,'year'=>$saleDetails->year,
                                                            'currentYear'=>$year,'lastYear'=>$lastYear,'month'=>$saleDetails->name]);
    }//getMonthlyPublicAuctionSales



    public function convertIntoUSD($details){
        $dollar_value = $details['current_dollar_value'];

        $oneRupeePrice = 1 / $dollar_value;
        $priceUSD = [];
        $todateUSD = [];

        foreach ($details['values'] as $key => $singleWeeklyValue) {    
            if ($singleWeeklyValue == NULL) {
                $priceUSD[$key] = NULL;
                $todateUSD[$key] = NULL;
            }else {
                
                $singleWeeklyValue = floatval(preg_replace('/[^\d.]/', '', $singleWeeklyValue));
                $details['todate_values'][$key] = floatval(preg_replace('/[^\d.]/', '', $details['todate_values'][$key]));
                $priceUSD[$key] = round($singleWeeklyValue * $oneRupeePrice, 2);
                $todateUSD[$key] = round($details['todate_values'][$key] * $oneRupeePrice, 2);
            }            
        }

        return array('priceUSD'=>$priceUSD,'todateUSD'=>$todateUSD);

    }//convertIntoUSD

    public function createPublicAuction($detailsArray){
        $message = 'Failed to create!';
        $value = 0;
        $redirect = '';
        $res = 0;      
        
        $publicReferences = $this->fetchData(new reference_public_auction_sales());
        
        $current_dollar_value = DB::table('sales_list')
                                    ->where('sales_code', '=' ,$detailsArray['sale_code'])
                                    ->select('current_dollar_value')
                                    ->first();

        $prevDataArray = $this->fetchPreviousYearSaleData($detailsArray['sale_code']);
                                            
        if (($current_dollar_value->current_dollar_value == 0) | ($current_dollar_value->current_dollar_value == NULL)) {
            $message = 'Please enter the current dollar value for the market report '.$detailsArray['sale_code'].' to proceed!';
            
        }else {
            
            $salvetoMain = new public_auction_sale_main();
            $salvetoMain->sales_code = $detailsArray['sale_code'];
            $salvetoMain->title = '';
            $salvetoMain->date_in_text = '';
            $salvetoMain->source_1 = $detailsArray['source_1'];
            $salvetoMain->source_2 = $detailsArray['source_2'];
            $salvetoMain->type = $detailsArray['sale_type'];
            $result = $salvetoMain->save();            
            
            if ($result) {
                $convertedValues = $this->convertIntoUSD(array('current_dollar_value'=>$current_dollar_value->current_dollar_value,'values'=>$detailsArray['values'],'todate_values'=>$detailsArray['todate_values']));
                
                $latest_id = DB::table('public_auction_sale_main')->orderBy('id', 'desc')->value('id');
                
                foreach ($publicReferences as $key => $singleRef) {
                    $singleValue = NULL;
                    $todateValue = NULL;
                    if ($detailsArray['values'][$key] != NULL) {
                        $singleValue = floatval(preg_replace('/[^\d.]/', '', $detailsArray['values'][$key]));
                    }
    
                    if ($detailsArray['todate_values'][$key] != NULL) {
                        $todateValue = floatval(preg_replace('/[^\d.]/', '', $detailsArray['todate_values'][$key]));
                    }

                    $lkr_status = $todate_lkr_status = $usd_status = $todate_usd_status = 'NO';
                    if (count($prevDataArray) > 0) {
                        $lkr_status = ($singleValue > $prevDataArray[$key]->price_lkr) ? '1': (($singleValue < $prevDataArray[$key]->price_lkr) ? '0' : 'NO');
                        $todate_lkr_status = ($todateValue > $prevDataArray[$key]->todate_price_lkr) ? '1': (($todateValue < $prevDataArray[$key]->todate_price_lkr) ? '0' : 'NO');
                        $usd_status = ($convertedValues['priceUSD'][$key] > $prevDataArray[$key]->price_usd) ? '1': (($convertedValues['priceUSD'][$key] < $prevDataArray[$key]->price_usd) ? '0' : 'NO');
                        $todate_usd_status = ($convertedValues['todateUSD'][$key] > $prevDataArray[$key]->todate_price_usd) ? '1': (($convertedValues['todateUSD'][$key] < $prevDataArray[$key]->todate_price_usd) ? '0' : 'NO');
                    }
                    
                    $res = public_auction_sale_details::create([
                        'public_auction_main_id'=>$latest_id,
                        'reference_id' => $singleRef->id,
                        'price_lkr' => $singleValue,
                        'lkr_status' => $lkr_status,
                        'todate_price_lkr'=>$todateValue,
                        'todate_lkr_status'=>$todate_lkr_status,
                        'price_usd' => $convertedValues['priceUSD'][$key],
                        'usd_status' => $usd_status,
                        'todate_price_usd' => $convertedValues['todateUSD'][$key],
                        'todate_usd_status' => $todate_usd_status,
                    ]);
                }  
    
                if ($res) {
                    $message = 'Public Auction Weekly Average details added successfully!';
                    $value = 1;        
                    
                } else {
                    $message = 'Public Auction Weekly Average details are not added!';
                }
            }           
        }
        
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );      
    }//createPublicAuction


    public function updatePublicAuction($detailsArray){
        $message = 'Failed to update!';
        $value = 0;
        $redirect = '';
        $res = 0;        

        $publicReferences = $this->fetchData(new reference_public_auction_sales());
        
        $current_dollar_value = DB::table('sales_list')
                                    ->where('sales_code', '=' ,$detailsArray['sale_code'])
                                    ->select('current_dollar_value')
                                    ->first();

        $prevDataArray = $this->fetchPreviousYearSaleData($detailsArray['sale_code']);


        if (($current_dollar_value->current_dollar_value == 0) | ($current_dollar_value->current_dollar_value == NULL)) {

            $message = 'Please enter the current dollar value '.$detailsArray['sale_code'].' to proceed!';
        }else {
        
            $convertedValues = $this->convertIntoUSD(array('current_dollar_value'=>$current_dollar_value->current_dollar_value,'values'=>$detailsArray['values'],'todate_values'=>$detailsArray['todate_values']));

            $publicMain = DB::table('public_auction_sale_main')
                                    ->where('sales_code', '=' ,$detailsArray['sale_code'])
                                    ->where('type','=',$detailsArray['sale_type'])
                                    ->first();

            $deleteDetails = DB::table('public_auction_sale_details')
                            ->where('public_auction_main_id', '=' ,$publicMain->id)
                            ->delete();

            if ($deleteDetails) {
                $salvetoMain = public_auction_sale_main::find($publicMain->id);
                
                $salvetoMain->sales_code = $detailsArray['sale_code'];
                $salvetoMain->title = '';
                $salvetoMain->date_in_text = '';
                $salvetoMain->source_1 = $detailsArray['source_1'];
                $salvetoMain->source_2 = $detailsArray['source_2'];
                // $salvetoMain->type = $detailsArray['sale_type'];
                $result = $salvetoMain->save();  
                               
                foreach ($publicReferences as $key => $singleRef) {
                    
                    $singleValue = NULL;
                    $todateValue = NULL;
                    if ($detailsArray['values'][$key] != NULL) {
                        $singleValue = floatval(preg_replace('/[^\d.]/', '', $detailsArray['values'][$key]));
                    }

                    if ($detailsArray['todate_values'][$key] != NULL) {
                        $todateValue = floatval(preg_replace('/[^\d.]/', '', $detailsArray['todate_values'][$key]));
                    }
                    
                    $lkr_status = $todate_lkr_status = $usd_status = $todate_usd_status = 'NO';
                    if (count($prevDataArray) > 0) {
                        $lkr_status = ($singleValue > $prevDataArray[$key]->price_lkr) ? '1': (($singleValue < $prevDataArray[$key]->price_lkr) ? '0' : 'NO');
                        $todate_lkr_status = ($todateValue > $prevDataArray[$key]->todate_price_lkr) ? '1': (($todateValue < $prevDataArray[$key]->todate_price_lkr) ? '0' : 'NO');
                        $usd_status = ($convertedValues['priceUSD'][$key] > $prevDataArray[$key]->price_usd) ? '1': (($convertedValues['priceUSD'][$key] < $prevDataArray[$key]->price_usd) ? '0' : 'NO');
                        $todate_usd_status = ($convertedValues['todateUSD'][$key] > $prevDataArray[$key]->todate_price_usd) ? '1': (($convertedValues['todateUSD'][$key] < $prevDataArray[$key]->todate_price_usd) ? '0' : 'NO');
                    }
                    
                    $res = public_auction_sale_details::create([
                        'public_auction_main_id'=>$publicMain->id,
                        'reference_id' => $singleRef->id,
                        'price_lkr' => $singleValue,
                        'lkr_status' => $lkr_status,
                        'todate_price_lkr'=>$todateValue,
                        'todate_lkr_status'=>$todate_lkr_status,
                        'price_usd' => $convertedValues['priceUSD'][$key],
                        'usd_status' => $usd_status,
                        'todate_price_usd' => $convertedValues['priceUSD'][$key],
                        'todate_usd_status' => $todate_usd_status,
                    ]);
                }  

                $type = 'Weekly';
                if ($detailsArray['sale_type'] == 'MONTHLY') {
                    $type = 'Monthly';
                }

                if ($res) {
                    $message = 'Public Auction '.$type.' Average details updated successfully!';
                    $value = 1;        
                    
                } else {
                    $message = 'Public Auction '.$type.' Average details are not updated!';
                }
            }
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );      
    }//updatePublicAuction


    public function manipulatePublicSales(Request $request){

        $status = array();      
        $finalArray = array();        
        $references = $this->fetchData(new reference_public_auction_sales());  
        $sale_type = $request->sale_type;   

        $previous_sale_code = $request->previous_sale_code;
        $namesArray = $request->reference;
        $values = $request->value;
        $todate_values = $request->todate_value;
        // $todat_statusArray = [];
        // $lkr_statusArray = [];

        // foreach ($references as $key => $value) {
        //     $lkr_statusArray[$key] = array();
        //     $todat_statusArray[$key] = array();
                                 
        //     $w_state = 'lkr_status_'.$key;
        //     $value = $request->$w_state;            
        //     $lkr_statusArray[$key] = $value;

        //     $t_state = 't_status_'.$key;
        //     $value = $request->$t_state;               
        //     $todat_statusArray[$key] = $value;
        // }              

        $prevSaleAvailability = $this->fetchDetailsBySalesCode(new sales_list(),'sales_code',$previous_sale_code);

        if ($prevSaleAvailability != NULL) {
                $availability = DB::table('public_auction_sale_main')
                                        ->where('sales_code', '=' ,$previous_sale_code)
                                        ->where('type','=',$sale_type)
                                        ->first();

                $detailArray = array('values'=>$values,'todate_values'=>$todate_values,
                                    // 'current_status'=>$lkr_statusArray,'todate_status'=>$todat_statusArray,
                                    'references'=>$namesArray,'sale_type'=>$sale_type,
                                    'source_1'=>$request->source_1,'source_2'=>$request->source_2,
                                    'sale_code'=>$previous_sale_code);

            if ($availability == NULL) {
                $status = $this->createPublicAuction($detailArray);
            } else {
                $status = $this->updatePublicAuction($detailArray);
            }
        }else{
            $status['message'] = 'Sales Report '.$previous_sale_code.' is not available. Create the report and enter data!';
            $status['value'] = 0;
            $status['redirect'] = '';
        }
      
        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);
    }//manipulatePublicSales

}
