<?php

namespace App\Http\Controllers\_PDF\Colombo_auctions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderOfSaleController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');  
            
            return $next($request);
        });
    }

    private function getOrderOfSalesDetails(){
        $dataSet = DB::table('order_of_sale_details')
                            ->where('sale_code','=',$this->session_sale_code)
                            ->select('column_1_details','column_2_details','column_3_details')
                            ->get();

         return $dataSet;

    }//getOrderOfSalesDetails


    public function fetchOrderOfSales(){
        
        $dataArray = $this->getOrderOfSalesDetails();
        
        return $dataArray;

    }//fetchOrderOfSales
}
