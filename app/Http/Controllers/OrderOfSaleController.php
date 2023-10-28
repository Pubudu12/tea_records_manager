<?php

namespace App\Http\Controllers;

use App\Http\Traits\DBOperationsTrait;
use App\Models\order_of_sale_details;
use App\Models\reference_awaiting_lots_quantity;
use App\Models\sales_list;
use App\Models\settlement_dates;
use App\Models\vendors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderOfSaleController extends Controller
{
    use DBOperationsTrait;

    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');  
            
            return $next($request);
        });
    }

    public function fetchAwaitingLotsAndQty(){
        $awaitingLotsQtyDetails = DB::table('awaiting_lots_and_qty')
                        ->leftjoin('reference_awaiting_lots_quantity', 'reference_awaiting_lots_quantity.id', '=', 'awaiting_lots_and_qty.ref_id')
                        ->where('awaiting_lots_and_qty.sale_code','=',$this->session_sale_code)
                        ->select('reference_awaiting_lots_quantity.name AS refName','reference_awaiting_lots_quantity.code AS refCode','reference_awaiting_lots_quantity.id AS refID','awaiting_lots_and_qty.*')
                        ->get();

        return $awaitingLotsQtyDetails;
    }

    public function getOrderOfSaleDetails(){
        $field = 'sale_code';
        $saleReportDay_1 = date('Y-m-d');
        $vendors = $this->fetchData(new vendors());  

        $fetchAwaitingLotsQty = $this->fetchAwaitingLotsAndQty();    

        $saleReportDetails = $this->fetchDetailsBySalesCode(new sales_list(),'sales_code',$this->session_sale_code);
        if ($saleReportDetails != NULL) {
            $saleReportDay_1 = date('Y-m-d',strtotime($saleReportDetails->report_day_one));
        }

        $orderOfSaleDetails = $this->fetchDataSetBySaleCode(new order_of_sale_details(), 'sale_code', $this->session_sale_code);

        $settlements = $this->fetchDataSetBySaleCode(new settlement_dates(), 'sale_code', $this->session_sale_code);

        $fetchReferences = $this->fetchData(new reference_awaiting_lots_quantity());
        
        return view('/colombo-auctions/orderOfSales',['orderOfSaleDetails'=>$orderOfSaleDetails, 'settlements'=>$settlements ,'fetchAwaitingLotsQty'=>$fetchAwaitingLotsQty,'references'=>$fetchReferences,'saleReportDay_1'=>$saleReportDay_1,'vendors'=>$vendors,'sale_code'=>$this->session_sale_code]);
    }//getOrderOfSaleDetails


    public function createDateSettlements($detailArray){
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;

        $settlements = new settlement_dates();
      
        $settlements->type = 'TITLE';
        $settlements->sale_code = $this->session_sale_code;
        $settlements->small_desc = $detailArray['small_desc'];

        if (str_word_count($detailArray['small_desc']) > 30) {
            $message = "The maximum word count is 30 !";
        } else {
            $res = $settlements->save();        

            for ($i=1; $i < 4; $i++) {
                $result = settlement_dates::create([
                    'sale_code' => $this->session_sale_code,
                    'type' => 'DATE_SETTLEMENT',
                    'date' => $detailArray['settle_date_'.$i],
                    'small_desc' => $detailArray['settle_txt_'.$i],
                ]);                
            }
            
            if ($result) {
                $message = 'Date Settlements added successfully!';
                $value = 1;
                
                $redirect = '/crop-and-weather';
            } else {
                $message = 'Date Settlements not added!';
            }
        }
        
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }//createDateSettlements


    public function updateDateSettlements($detailArray){
        
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;
        
        // $fetchReferences = $this->fetchData(new reference_overall_market());

        $settlement = settlement_dates::select('id','type','sale_code','date','small_desc')
                    ->where('sale_code', '=',$this->session_sale_code)
                    ->where('type', '=', 'DATE_SETTLEMENT')
                    ->get();
                    
        for ($i=0; $i < 3; $i++) {
            $c = $i+1;
            $settlement[$i]->date = $detailArray['settle_date_'.$c];
            $settlement[$i]->small_desc = $detailArray['settle_txt_'.$c];
            $result = $settlement[$i]->save();   
        }

        $settle_quality = settlement_dates::select('id','type','sale_code','date','small_desc')
                    ->where('sale_code', '=',$this->session_sale_code)
                    ->where('type', '=', 'TITLE')
                    ->first();

        if (str_word_count($detailArray['small_desc']) > 30) {
            $message = "The maximum word count is 30 !";
            
        }else {
            
            $settle_quality->small_desc = $detailArray['small_desc'];
            $result = $settle_quality->save();  
            
            if ($result) {
                $message = 'Date Settlements updated successfully!';
                $value = 1;
                
                $redirect = '/crop-and-weather';
            } else {
                $message = 'Date Settlements are not updated!';
            }
        }        

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }//updateDateSettlements


    public function manipilateDateSettlemets(Request $request){
        $filedName = 'sale_code';
        $status = array();

        $availability = $this->fetchDataSetBySaleCode(new settlement_dates(), $filedName, $this->session_sale_code);
        $detailArray = array('settle_date_1'=>$request->settle_date_1,'settle_date_2'=>$request->settle_date_2,'settle_date_3'=>$request->settle_date_3,
                                'settle_txt_1'=>$request->settle_txt_1,'settle_txt_2'=>$request->settle_txt_2,'settle_txt_3'=>$request->settle_txt_3,
                                'small_desc'=>$request->small_desc);

        if (count($availability) == '0') {
            $status = $this->createDateSettlements($detailArray);
        } else {
            $status = $this->updateDateSettlements($detailArray);
        }
        
        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);
    }//manipilateDateSettlemets


    public function createOrderOfSalesDetails($detailArray){
        $message = 'Order of Sales is not added!';
        $value = 0;
        $redirect = '';
        $result = 0;

        $vendors = $this->fetchData(new vendors());

        $sale_code = $this->session_sale_code;
        if ($detailArray['sale_code'] != NULL) {
            $sale_code = $detailArray['sale_code'];
        }
        
        if ((count($vendors) == count($detailArray['column_1_data'])) & (count($vendors) == count($detailArray['column_2_data'])) & (count($vendors) == count($detailArray['column_3_data']))) {
            for ($i=0; $i < count($detailArray['column_1_data']); $i++) { 
                $result = order_of_sale_details::create([
                    'sale_code' => $sale_code,
                    'column_1_details' => $detailArray['column_1_data'][$i],
                    'column_2_details' => $detailArray['column_2_data'][$i],
                    'column_3_details' => $detailArray['column_3_data'][$i],
                    'type' => 'VENDOR'
                ]);
            }
        } else {
            $message = 'Please select all the fields!';
        }               

        if ($result) {
            $message = 'Order of Sales added successfully!';
            $value = 1;
        } 
        
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }//createOrderOfSalesDetails


    public function updateOrderOfSalesDetails($detailArray){
        $message = 'Order of Sales is not updated!';
        $value = 0;
        $redirect = '';
        $result = 0;
        $vendors = $this->fetchData(new vendors());

        $sale_code = $this->session_sale_code;
        if ($detailArray['sale_code'] != NULL) {
            $sale_code = $detailArray['sale_code'];
        }

        $dataset = $this->fetchDataSetBySaleCode(new order_of_sale_details(), 'sale_code', $this->session_sale_code);
        foreach ($dataset as $key => $value) {
            $res = $value->delete(); 
        }
        if ((count($vendors) == count($detailArray['column_1_data'])) & (count($vendors) == count($detailArray['column_2_data'])) & (count($vendors) == count($detailArray['column_3_data']))) {
            for ($i=0; $i < count($detailArray['column_1_data']); $i++) {
                $result = order_of_sale_details::create([
                    'sale_code' => $sale_code,
                    'column_1_details' => $detailArray['column_1_data'][$i],
                    'column_2_details' => $detailArray['column_2_data'][$i],
                    'column_3_details' => $detailArray['column_3_data'][$i],
                    'type' => 'VENDOR'
                ]);
            }
        }else{
            $message = 'Please select all the fields!';
        }

        if ($result) {
            $message = 'Order of Sales updated successfully!';
            $value = 1;
        } 
        
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }//updateOrderOfSalesDetails


    public function manipulateOrderOfSales(Request $request){
        $filedName = 'sale_code';
        $status = array();

        $column_1_data = $request->column_1_data;
        $column_2_data = $request->column_2_data;
        $column_3_data = $request->column_3_data;

        $sale_code = NULL;
        if (isset($request->awaiting_sale_code)) {
            $sale_code = $request->awaiting_sale_code;
        }

        $availability = $this->fetchDataSetBySaleCode(new order_of_sale_details(), $filedName, $this->session_sale_code);
        $detailArray = array('column_1_data'=>$column_1_data,'column_2_data'=>$column_2_data,'column_3_data'=>$column_3_data,'sale_code'=>$sale_code);

        if (count($availability) == '0') {
            $status = $this->createOrderOfSalesDetails($detailArray);
        } else {
            $status = $this->updateOrderOfSalesDetails($detailArray);
        }
        
        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);
    }//manipulateOrderOfSales
}