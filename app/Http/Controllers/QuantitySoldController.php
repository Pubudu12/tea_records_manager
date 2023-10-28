<?php

namespace App\Http\Controllers;

use App\Http\Traits\DBOperationsTrait;
use App\Models\quantity_sold_rows;
use App\Models\quantity_sold_summary;
use App\Models\sales_list;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class QuantitySoldController extends Controller
{
    use DBOperationsTrait;

    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');

            return $next($request);
        });
    }


    public function fetchQuantitySold(){
        $fetchQuantitySold = DB::table('quantity_sold_summary')
                        ->leftjoin('quantity_sold_rows', 'quantity_sold_rows.id', '=', 'quantity_sold_summary.quantity_sold_row_id')
                        ->where('quantity_sold_summary.sales_code','=',$this->session_sale_code)
                        ->select('quantity_sold_rows.row_name','quantity_sold_summary.*')
                        ->get();

        return $fetchQuantitySold;
    }//fetchQuantitySold


    public function getQuantitySoldDetails(){
        $rowList = $this->fetchData(new quantity_sold_rows());
        $detailsArray['dataset'] = array(); 
        $date = date('d-m-Y');
        $detailsArray['date'] = $date;

        $fetchQuantitySold = $this->fetchQuantitySold();
        
        if (count($fetchQuantitySold) > 0){
            
            foreach ($fetchQuantitySold as $key => $value) {
                $date = $value->date;
                array_push($detailsArray['dataset'],array(
                    'type'=>$value->type,
                    'name'=>$value->row_name,
                    'weekly_price_kgs'=>($value->weekly_price_kgs != NULL) ? number_format($value->weekly_price_kgs,2) : '',
                    'todate_price_kgs'=>($value->todate_price_kgs != NULL) ? number_format($value->todate_price_kgs,2) : '',
                ));
            }
            $detailsArray['date'] = $date;            
        } else {
            foreach ($rowList as $key => $value) {  
                $type = 'ROW';              
                if ($value->code == 'TOTAL') {
                    $type = 'TOTAL';
                }
                if ($value->code == 'BMF') {
                    $type = 'BMF';
                }
                array_push($detailsArray['dataset'],array(
                    'type'=>$type,
                    'name'=>$value->row_name,
                    'weekly_price_kgs'=>'',
                    'todate_price_kgs'=>''
                ));
            }   
        }

        $fetchsalesDetails = $this->fetchDetailsBySalesCode(new sales_list(), 'sales_code', $this->session_sale_code);

        $formedDate = $this->formDateInTextFormat(new sales_list(), 'sales_Code', $this->session_sale_code);
        return view('tea-statistics/quantitySold',['rowlist'=>$rowList,'fetchsalesDetails'=>$fetchsalesDetails,'fetchQuantitySold'=>$fetchQuantitySold,'detailsArray'=>$detailsArray,'formedDate'=>$formedDate]);
        
    }//getQuantitySoldDetails


    public function createQuantitySold($rowValues,$rowTypes,$row_value_todate,$date){
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;

        $quantity_sold_rows = $this->fetchData(new quantity_sold_rows());
        
        foreach ($quantity_sold_rows as $key => $singleRef) {

            $type = 'ROW';
            if ($singleRef->code == 'TOTAL') {
                $type = 'TOTAL';
            }

            if ($singleRef->code == 'BMF') {
                $type = 'BMF';
            }

            $weekval = NULL;
            $todateval = NULL;
            if ($rowValues[$key] != NULL) {
                $weekval = floatval(preg_replace('/[^\d.-]/', '', $rowValues[$key]));
            }
            if ($row_value_todate[$key] != NULL) {
                $todateval = floatval(preg_replace('/[^\d.-]/', '', $row_value_todate[$key]));
            }

            $result = quantity_sold_summary::create([
                'sales_code' => $this->session_sale_code,
                'quantity_sold_row_id' => $singleRef->id,
                'date'=>$date,
                'weekly_price_kgs' => $weekval,
                'todate_price_kgs' => $todateval,
                'type'=>$type
            ]);
        }

        if ($result) {
            $message = 'Quantity Sold details added successfully!';
            $value = 1;
            
            $redirect = '/rates-of-exchange';
        } else {
            $message = 'Quantity Sold details are not added!';
        }
        
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }//createQuantitySold

    public function updateQuantitySold($rowValues,$row_type,$row_value_todate,$date){
        
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;
        
        $quantity_sold_rows = $this->fetchData(new quantity_sold_rows());

        // $todateValues = $this->calculateTodateValues($rowValues, 'quantity_sold_summary',$this->session_sale_code);
        
        foreach ($quantity_sold_rows as $key => $ref) {
            
            $quantitySoldSummary = quantity_sold_summary::select('id','quantity_sold_row_id','weekly_price_kgs','todate_price_kgs')
                        ->where('sales_code', '=',$this->session_sale_code)
                        ->where('quantity_sold_row_id', '=', $ref->id)
                        ->first();
        
            $weekval = NULL;
            $todateval = NULL;
            if ($rowValues[$key] != NULL) {
                $weekval = floatval(preg_replace('/[^\d.-]/', '', $rowValues[$key]));
            }
            if ($row_value_todate[$key] != NULL) {
                $todateval = floatval(preg_replace('/[^\d.-]/', '', $row_value_todate[$key]));
            }

            $quantitySoldSummary->date = $date;
            $quantitySoldSummary->weekly_price_kgs = $weekval;
            $quantitySoldSummary->todate_price_kgs = $todateval;
            $quantitySoldSummary->type = $row_type[$key];
            $result = $quantitySoldSummary->save();            
        }
        
        if ($result) {
            $message = 'Quantity Sold details updated successfully!';
            $value = 1;
            
            $redirect = '/rates-of-exchange';
        } else {
            $message = 'Quantity Sold details are not updated!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }//updateQuantitySold

    public function manipulateQuantitySoldDetails(Request $request){
        $status = array();

        $availability = $this->fetchQuantitySold();
        
        $row_value = $request->row_value;
        $row_type = $request->type;
        $row_value_todate = $request->row_value_todate;
        $date = $request->quantitySoldDate;
        
        if (count($availability) == 0) {
            $status = $this->createQuantitySold($row_value,$row_type,$row_value_todate,$date);
        } else {
            $status = $this->updateQuantitySold($row_value,$row_type,$row_value_todate,$date);
        }
        
        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);
    }//manipulateQuantitySoldDetails
}
