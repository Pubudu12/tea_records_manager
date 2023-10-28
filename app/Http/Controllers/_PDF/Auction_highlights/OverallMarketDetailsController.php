<?php

namespace App\Http\Controllers\_PDF\Auction_highlights;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OverallMarketDetailsController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');  
            
            return $next($request);
        });
    }
    
    private function getOverallDetails(){
        $dataArray = array();
        $dataSet = DB::table('overall_detail_values')
                       ->leftJoin('reference_overall_elevations','reference_overall_elevations.code','=','overall_detail_values.reference_elevation')
                       ->where('overall_detail_values.sales_code','=',$this->session_sale_code)
                       ->select('overall_detail_values.overall_detail_values','overall_detail_values.overall_status_values',
                                'overall_detail_values.type','reference_overall_elevations.name','reference_overall_elevations.code',
                                'reference_overall_elevations.column_includes','reference_overall_elevations.columns',
                                'reference_overall_elevations.level')
                       ->get();

        foreach ($dataSet as $key => $value) {
            $dataArray[$key] = array(
                'name'=>$value->name,
                'code'=>$value->code,
                'column_includes'=>$value->column_includes,
                'columns'=>json_decode($value->columns),
                'overall_detail_values'=>json_decode($value->overall_detail_values),
                'overall_status_values'=>json_decode($value->overall_status_values),
                'name'=>$value->name,
            );
        }

         return $dataArray;

    }//getOverallDetails

    public function fetchOverallMarketDetails(){
        $overallMarketDetails = $this->getOverallDetails();
        
        return $overallMarketDetails;
    }
}
