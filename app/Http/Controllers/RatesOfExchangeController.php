<?php

namespace App\Http\Controllers;

use App\Http\Traits\DBOperationsTrait;
use App\Models\rates_of_exchange;
use App\Models\sales_list;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatesOfExchangeController extends Controller
{

    use DBOperationsTrait;

    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');

            return $next($request);
        });
    }

    public function getQuantitySoldDetails(){
        
        $ratesExchange = $this->fetchDetailsBySalesCode(new rates_of_exchange(), 'sales_code', $this->session_sale_code);

        $fetchsalesDetails = $this->fetchDetailsBySalesCode(new sales_list(), 'sales_code', $this->session_sale_code);
        return view('tea-statistics/ratesOfExchange',['ratesExchange'=>$ratesExchange,'fetchsalesDetails'=>$fetchsalesDetails]);

    }//getQuantitySoldDetails


   public function createRatesExchange($request){
    $message = 'Failed to update!';
    $value = 0;
    $redirect = '';

    $rates = new rates_of_exchange();

    $rates->sales_code = $this->session_sale_code;
    $rates->year = $request->year;
    $rates->usd = ($request->usd_price != NULL) ? floatval(preg_replace('/[^\d.]/', '', $request->usd_price)) : NULL;
    $rates->stg_pd = ($request->usd_price != NULL) ? floatval(preg_replace('/[^\d.]/', '', $request->stg_price)) : NULL;
    $rates->euro =($request->usd_price != NULL) ? floatval(preg_replace('/[^\d.]/', '',  $request->euro_price)) : NULL;
    $rates->yuan = ($request->usd_price != NULL) ? floatval(preg_replace('/[^\d.]/', '', $request->yuan_price)) : NULL;
    $rates->source_text = $request->source;

    $result = $rates->save();

    if ($result) {
        $message = 'Rates of Exchange details created Successfully!';
        $value = 1;
        $redirect = '/market-dashboard';
    } else {
        $message = 'Rates of Exchange details are not created!';
    }
    
    return array(
        'message' => $message,
        'value' => $value,
        'redirect'=> $redirect
    );

   }//createRatesExchange


   public function updateRatesExchange($request){
    $message = 'Failed to update!';
    $value = 0;
    $redirect = '';
    $result = 0;

    $data = rates_of_exchange::where('sales_code', $this->session_sale_code)->first();        

    
    $data->year = $request->year;
    $data->usd = ($request->usd_price != NULL) ? floatval(preg_replace('/[^\d.]/', '', $request->usd_price)) : NULL;
    $data->stg_pd = ($request->stg_price != NULL) ? floatval(preg_replace('/[^\d.]/', '', $request->stg_price)) : NULL;
    $data->euro = ($request->euro_price != NULL) ? floatval(preg_replace('/[^\d.]/', '',  $request->euro_price)) : NULL;
    $data->yuan = ($request->yuan_price != NULL) ? floatval(preg_replace('/[^\d.]/', '', $request->yuan_price)) : NULL;
    $data->source_text = $request->source;

    $result = $data->save();
    
    if ($result) {
        $message = 'Rated of Exchange details updated Successfully!';
        $value = 1;
    } else {
        $message = 'Rated of Exchange details are not updated!';
    }
     

     return array(
        'message' => $message,
        'value' => $value,
        'redirect'=> $redirect
        );
   }//updateRatesExchange


    public function manipulateRatesExchange(Request $request){
        $status = array();

        $availability = $this->fetchDetailsBySalesCode(new rates_of_exchange(), 'sales_code', $this->session_sale_code);
        
        if ($availability == NULL) {
            $status = $this->createRatesExchange($request);
        } else {
            $status = $this->updateRatesExchange($request);
        }
        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);
    }//manipulateRatesExchange

}
