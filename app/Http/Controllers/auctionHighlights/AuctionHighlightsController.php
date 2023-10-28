<?php

namespace App\Http\Controllers\auctionHighlights;

use App\Http\Controllers\Controller;

use App\Http\Traits\DBOperationsTrait;
use App\Models\auction_descriptions;
use App\Models\details_of_qualtity_sold;
use App\Models\sales_list;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuctionHighlightsController extends Controller
{
    use DBOperationsTrait;

    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');  
            
            return $next($request);
        });
    }

    public function convertIntoUSD(Request $details){
        $sale_code = $details['sale_code'];
        $lkr_value =$details['avg_lkr'];

        $dollar_value = DB::table('sales_list')
                            ->where('sales_code','=' ,$sale_code)
                            ->select('current_dollar_value')
                            ->first();

        $oneRupeePrice = 1 / $dollar_value->current_dollar_value;
        $priceUSD = 0;
          
        if ($lkr_value == NULL) {
            $priceUSD = NULL;
        }else {
            
            $lkr_value = floatval(preg_replace('/[^\d.]/', '', $lkr_value));
            $priceUSD = round($lkr_value * $oneRupeePrice, 2);
        }            
        

        return array('priceUSD'=>$priceUSD);

    }//convertIntoUSD

    public function fetchPreviousYearSaleData(){
        $currentData = DB::table('sales_list')
                            ->where('sales_code','=' ,$this->session_sale_code)
                            ->select('year','sales_no')
                            ->first();

        $currentYear = $currentData->year;
        $currentSaleNo = $currentData->sales_no;

        $prevYear = (int)$currentYear - 1;
        $prevSaleCode = $prevYear.'-'.$currentSaleNo;

        $yearBeforePrevYear = (int)$prevYear - 1;
        $yearBeforePrevSaleCode = $yearBeforePrevYear.'-'.$currentSaleNo;

        $yearBeforePrevYearTotalValues = DB::table('details_of_qualtity_sold')
                                        ->where('sale_code','=' ,$yearBeforePrevSaleCode)
                                        ->select('quantity_m_kgs','avg_price_lkr','avg_price_usd',)
                                        ->first();

        $prevYearSaleTotalValues = DB::table('details_of_qualtity_sold')
                                        ->where('sale_code','=' ,$prevSaleCode)
                                        ->select('quantity_m_kgs','avg_price_lkr','avg_price_usd',)
                                        ->first();

        return array('yearBeforePrevYearTotalValues'=>$yearBeforePrevYearTotalValues,'prevYearSaleTotalValues'=>$prevYearSaleTotalValues);
    }//fetchPreviousYearSaleData


    public function fetchMarketDashboard(){
        
        $fetchMarketDashboardDetails = $this->fetchDetailsBySalesCode(new sales_list(), 'sales_code', $this->session_sale_code);
        $market_details = $this->fetchDetailsBySalesCode(new details_of_qualtity_sold(), 'sale_code', $this->session_sale_code);      
             
        $previousData = $this->fetchPreviousYearSaleData();   
        $prevDataArray = array();
              
        if ($previousData['yearBeforePrevYearTotalValues'] != NULL) {
            $prevDataArray['yearBeforePrevYearTotalValues']['quantity_m_kgs'] = number_format($previousData['yearBeforePrevYearTotalValues']->quantity_m_kgs,2);
            $prevDataArray['yearBeforePrevYearTotalValues']['avg_price_lkr'] = number_format($previousData['yearBeforePrevYearTotalValues']->avg_price_lkr,2);
            $prevDataArray['yearBeforePrevYearTotalValues']['avg_price_usd'] = number_format($previousData['yearBeforePrevYearTotalValues']->avg_price_usd,2);
        } else {
            $prevDataArray['yearBeforePrevYearTotalValues']['quantity_m_kgs'] = '';
            $prevDataArray['yearBeforePrevYearTotalValues']['avg_price_lkr'] = '';
            $prevDataArray['yearBeforePrevYearTotalValues']['avg_price_usd'] = '';
        }   
        
        
        if ($previousData['prevYearSaleTotalValues'] != NULL) {
            $prevDataArray['prevYearSaleTotalValues']['quantity_m_kgs'] = number_format($previousData['prevYearSaleTotalValues']->quantity_m_kgs,2);
            $prevDataArray['prevYearSaleTotalValues']['avg_price_lkr'] = number_format($previousData['prevYearSaleTotalValues']->avg_price_lkr,2);
            $prevDataArray['prevYearSaleTotalValues']['avg_price_usd'] = number_format($previousData['prevYearSaleTotalValues']->avg_price_usd,2);
        } else {
            $prevDataArray['prevYearSaleTotalValues']['quantity_m_kgs'] = '';
            $prevDataArray['prevYearSaleTotalValues']['avg_price_lkr'] = '';
            $prevDataArray['prevYearSaleTotalValues']['avg_price_usd'] = '';
        }      

        $year = $fetchMarketDashboardDetails->year;        
        $lastYear = ((int)$year) - 1;
        $yearBeforeLastYear = ((int)$lastYear) - 1;

        return view('/auction-Highlights/marketDashboard',['fetchMarketDashboardDetails'=>$fetchMarketDashboardDetails,'marketDetails'=>$market_details,
                                                                'currentYear'=>$year,'lastYear'=>$lastYear,'yearBeforeLastYear'=>$yearBeforeLastYear,'previousDataArray'=>$prevDataArray]);
        
    }//fetchMarketDashboard


    public function createMarketDashboard($request){
        $message = '';
        $value = 0;
        $redirect = '';

        $report = new details_of_qualtity_sold();

        $validation = Validator::make($request->all(),[
            'qty'=>'required',
            'avg_lkr'=>'required',
            'avg_usd'=>'required',
        ]);

        if ($validation->fails()) {
            $message = 'Please Enter All Details!';
        }else{
                        
            $report->sale_code = $this->session_sale_code;
            $report->year = $request->year;
            $report->quantity_m_kgs = floatval(preg_replace('/[^\d.]/', '', $request->qty));
            $report->avg_price_lkr = floatval(preg_replace('/[^\d.]/', '', $request->avg_lkr));
            $report->avg_price_usd = floatval(preg_replace('/[^\d.]/', '', $request->avg_usd));

            $result = $report->save();

            if ($result) {
                $message = 'Market Dashboard details added successfully!';
                $value = 1;
                
                $redirect = '/overall-market';
            } else {
                $message = 'Market Dashboard details are not added!';
            }
        }
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }//createMarketDashboard

    public function updateMarketDashboard($request){
        $message = '';
        $value = 0;
        $redirect = '';
        
        $data = details_of_qualtity_sold::where('sale_code', '=', $this->session_sale_code)->first();

        $validation = Validator::make($request->all(),[
            'qty'=>'required',
            'avg_lkr'=>'required',
            'avg_usd'=>'required',
        ]);

        if ($validation->fails()) {
            $message = 'Please Enter all details!';
        }else{
                        
            $data->year = $request->year;
            $data->quantity_m_kgs = floatval(preg_replace('/[^\d.]/', '', $request->qty));
            $data->avg_price_lkr = floatval(preg_replace('/[^\d.]/', '', $request->avg_lkr));
            $data->avg_price_usd = floatval(preg_replace('/[^\d.]/', '', $request->avg_usd));

            $result = $data->save();

            if ($result) {
                $message = 'Market Dashboard details updated successfully!';
                $value = 1;
            
                $redirect = '/overall-market';
            } else {
                $message = 'Market Dashboard details are not updated!';
            }
        }
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }//updateMarketDashboard 
    

    public function manipulateMarketDashboardDetails(Request $request){
        $filedName = 'sale_code';
        $status = array();

        $availability = $this->checkDetailAvailability(new details_of_qualtity_sold(), $filedName, $this->session_sale_code);

        if ($availability == 1) {
            $status = $this->updateMarketDashboard($request);
        } else {
            $status = $this->createMarketDashboard($request);
        }
        
        return json_encode(array(
            'message' => $status['message'],
            'result' => $status['value'],
            'redirect'=> $status['redirect']            
        ),200);

    }//addMarketDashboardDetails



    //-------------------------------Auction Descriptions--------------------------

    public function fetchAuctionDescriptions(){
        $filedName = 'sale_code';        

        $auctionDescriptions = $this->fetchDataSetBySaleCode(new auction_descriptions(), $filedName, $this->session_sale_code);
        
        return view('/auction-Highlights/highlights',['auctionDescriptions'=>$auctionDescriptions,'sale_code'=>$this->session_sale_code]);
    }//fetchAuctionDescriptions


    public function createAuctionDescription($highlights){
        $message = 'Auction Highlight not added!';
        $value = 0;
        $redirect = '';
        $result = 0;

        $overall = new auction_descriptions();
        if (str_word_count($highlights['highlight_desc']) > 60) {
            $message = "The maximum word count is 60 !";
        }else{
            if ($highlights['highlight_desc'] != NULL) {
                $overall->sale_code = $this->session_sale_code;
                $overall->description_title = $highlights['highlight_name'];
                $overall->description = $highlights['highlight_desc'];
                $overall->type = 'HIGHLIGHT';
    
                $result = $overall->save();
            }  
        }           
               
        if ($result) {
            $message = 'Auction Highlight added successfully!';
            $value = 1;
            
            $redirect = '/order-of-sales';
        } else {
            // $message = 'Auction Highlight are not added!';
        }
        
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }//createAuctionDescription


    public function updateAuctionDescription($highlights){
        
        $message = 'Auction Highlight not updated!';
        $value = 0;
        $redirect = '';
        $result = 0;

        $descriptions = auction_descriptions::select('id','description_title','description')
                                            ->where('sale_code', '=',$this->session_sale_code)
                                            ->where('type', '=', 'HIGHLIGHT')
                                            ->first();
        if ($descriptions != NULL) {
            if (str_word_count($highlights['highlight_desc']) > 60) {
                $message = "The maximum word count is 60 !";
            }else{
                $descriptions->description_title = $highlights['highlight_name'];
                $descriptions->description = $highlights['highlight_desc'];
                $result = $descriptions->save();
            }           
        }
        
        if ($result) {
            $message = 'Auction Highlight updated successfully!';
            $value = 1;
            
            $redirect = '/order-of-sales';
        } else {
            // $message = 'Auction Highlight are not updated!';
        }
        
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }//updateAuctionDescription


    public function manipulateAuctionSmallDesc(Request $request){
        $status = array();

        $description = auction_descriptions::select('id')
                                            ->where('sale_code', '=',$this->session_sale_code)
                                            ->where('type', '=', 'HIGHLIGHT')
                                            ->first();
        
        $highlights = array('highlight_name'=>$request->highlight_name,'highlight_desc'=>$request->highlight_desc);
        
        if ($description == NULL) {
            $status = $this->createAuctionDescription($highlights);
        } else {
            $status = $this->updateAuctionDescription($highlights);
        }
        
        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);
    }//manipulateAuctionSmallDesc




    public function createAuctionLongDescription($auction_desc_title,$auction_desc){
        $message = 'Auction Highlight not added!';
        $value = 0;
        $redirect = '';
        $result = 0;

        foreach ($auction_desc_title as $key => $singleDesc) {     
            if ($auction_desc[$key] != NULL) {
                $result = auction_descriptions::create([
                    'sale_code' => $this->session_sale_code,
                    'description_title' => $singleDesc,
                    'description' => $auction_desc[$key],
                    'type' => 'DESCRIPTION',
                ]);
            }
        }

        if ($result) {
            $message = 'Auction Description added successfully!';
            $value = 1;
            
            $redirect = '/order-of-sales';
        } else {
            $message = 'Auction Description are not added!';
        }
        
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }


    public function updateAuctionLongDescription($auction_desc_title,$auction_desc){
        $message = 'Auction Highlight not updated!';
        $value = 0;
        $redirect = '';
        $result = 0;

        $longDesc = auction_descriptions::select('id','description_title','description')
                                            ->where('sale_code', '=',$this->session_sale_code)
                                            ->where('type', '=', 'DESCRIPTION')
                                            ->get();

        if (count($longDesc) > 0) {
            foreach ($longDesc as $key => $value) {
                $data = auction_descriptions::find($value->id);                                
                $delete_data =  $data->delete();
            }
        }

        foreach ($auction_desc_title as $key => $singleDesc) {     
            if ($auction_desc[$key] != NULL) {
                $result = auction_descriptions::create([
                    'sale_code' => $this->session_sale_code,
                    'description_title' => $singleDesc,
                    'description' => $auction_desc[$key],
                    'type' => 'DESCRIPTION',
                ]);
            }
        }

        if ($result) {
            $message = 'Auction Description updated successfully!';
            $value = 1;
            
            $redirect = '/order-of-sales';
        } else {
            $message = 'Auction Description are not updated!';
        }
        
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }


    public function manipulateAucLongDescriptions(Request $request){
        $filedName = 'sale_code';
        $status = array();

        $descriptions = auction_descriptions::select('id')
                                ->where('sale_code', '=',$this->session_sale_code)
                                ->where('type', '=', 'DESCRIPTION')
                                ->get();
        
        // $this->fetchDataSetBySaleCode(new auction_descriptions(), $filedName, $this->session_sale_code);
        
        $auction_desc_title = $request->auction_desc_title;
        $auction_desc = $request->auction_desc;

        if (count($descriptions) == '0') {
            $status = $this->createAuctionLongDescription($auction_desc_title, $auction_desc);
        } else {
            $status = $this->updateAuctionLongDescription($auction_desc_title, $auction_desc);
        }
        
        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);
    }//manipulateAuctionSmallDesc
}
