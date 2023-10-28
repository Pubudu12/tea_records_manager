<?php

namespace App\Http\Controllers\teaStatistics;

use App\Http\Controllers\Controller;
use App\Http\Traits\DBOperationsTrait;
use App\Models\import_countries;
use App\Models\months;
use App\Models\reference_world_tea_production;
use App\Models\sales_list;
use App\Models\world_tea_production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorldTeaProductionController extends Controller
{    
    use DBOperationsTrait;

    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');

            return $next($request);
        });
    }

    public function fetchPreviousSaleData($salecode,$type){
        $currentData = DB::table('sales_list')
                            ->where('sales_code','=' ,$salecode)
                            ->select('year','sales_no')
                            ->first();

        $currentYear = $currentData->year;
        $currentSaleNo = $currentData->sales_no;

        $prevYear = (int)$currentYear - 1;
        $prevSaleCode = $prevYear.'-'.$currentSaleNo;

        $yearBeforePrevYear = (int)$prevYear - 1;
        $yearBeforePrevSaleCode = $yearBeforePrevYear.'-'.$currentSaleNo;

        $prevYearSaleTotalValues = world_tea_production::select('current_year_price')
                                                ->where('sales_code', '=',$prevSaleCode)
                                                ->where('type', '=', $type)
                                                ->get(); 

        $yearBeofrePrevYearSaleTotalValues = world_tea_production::select('current_year_price')
                                                    ->where('sales_code', '=',$yearBeforePrevSaleCode)
                                                    ->where('type', '=', $type)
                                                    ->get(); 

        return array('yearBeofrePrevYearSaleTotalValues'=>$yearBeofrePrevYearSaleTotalValues,'prevYearSaleTotalValues'=>$prevYearSaleTotalValues);

    }//fetchPreviousSaleData

    public function fetchWorldTeaProductionDetails(){

        $months = $this->fetchData(new months());
        $dataArray = array();
        // $dataArray['onetolastMonthData'] = array();
        // $dataArray['secondtolastMonthData'] = array();
        $countries = $this->fetchData(new import_countries());      
        $refWorlTeaProd = $this->fetchData(new reference_world_tea_production());    

        $currentData = $this->fetchDetailsBySalesCode(new sales_list(),'sales_code',$this->session_sale_code);  
        // $availability = $this->fetchDataSetBySaleCode(new world_tea_production(), 'sales_code', $this->session_sale_code);
       
        $currentYear = (int)$currentData->year;
        $lastYear = $currentYear - 1;
        $prvLastYear = $currentYear - 2;
        
        $currentMonth = ($currentData->month);
        $last_month = $currentMonth - 1;
        $oneToLast_month = $currentMonth - 2;
        $secondToLast_month = $currentMonth - 3;

        if ($currentMonth == '1') {           
            $last_month = 12;
            $oneToLast_month = 11;
            $secondToLast_month = 10;
        }
        
        $txtLastMonth = months::find($last_month);
        $txtoneToLast_month = months::find($oneToLast_month);
        $txtsecondToLast_month = months::find($secondToLast_month);

        $lastMonthData = DB::table('world_tea_production')
                                ->leftjoin('reference_world_tea_production','reference_world_tea_production.id','=','world_tea_production.country_id')
                                ->where('world_tea_production.sales_code', '=',$this->session_sale_code)
                                // ->where('world_tea_production.type', '=', 'SELECTED_LAST_MONTH')
                                ->select('world_tea_production.*', 'reference_world_tea_production.name')
                                ->get();

        $lastMonthPreviousData = $this->fetchPreviousSaleData($this->session_sale_code,'SELECTED_LAST_MONTH');                                        

        $onetolastMonthData = DB::table('world_tea_production')
                                ->leftjoin('reference_world_tea_production','reference_world_tea_production.id','=','world_tea_production.country_id')
                                ->where('world_tea_production.sales_code', '=',$this->session_sale_code)
                                ->where('world_tea_production.type', '=', 'ONE_TO_LAST')
                                ->select('world_tea_production.*', 'reference_world_tea_production.name')
                                ->get();

        $oneToLastMonthPreviousData = $this->fetchPreviousSaleData($this->session_sale_code,'ONE_TO_LAST');                                           

        $secTolastMonthData = DB::table('world_tea_production')
                                ->leftjoin('reference_world_tea_production','reference_world_tea_production.id','=','world_tea_production.country_id')
                                ->where('world_tea_production.sales_code', '=',$this->session_sale_code)
                                ->where('world_tea_production.type', '=', 'SECOND_TO_LAST')
                                ->select('world_tea_production.*', 'reference_world_tea_production.name')
                                ->get();

        $secTolastMonthPreviousData = $this->fetchPreviousSaleData($this->session_sale_code,'SECOND_TO_LAST');   

        $dataArray[1]['name'] = 'SELECTED_LAST_MONTH';
        $dataArray[2]['name'] = 'ONE_TO_LAST';
        $dataArray[3]['name'] = 'SECOND_TO_LAST';

        $dataArray[1]['month'] = '';
        $dataArray[2]['month'] = '';
        $dataArray[3]['month'] = '';

        if (count($lastMonthData) > 0) {   
            $innerArray = array();                   

            foreach ($lastMonthData as $key => $value) {   
                
                $country = '';
                if ($value->name != NULL) {
                    $country = $value->name;
                }

                $countryId = '';
                if ($value->country_id != NULL) {
                    $countryId = $value->country_id;
                }
                
                $selected_year = '';
                if ($value->selected_year != NULL) {
                    $selected_year = $value->selected_year;
                }

                $selected_month = '';
                if ($value->selected_month != NULL) {
                    $selected_month = $value->selected_month;
                }

                $current_year_price = '';
                if ($value->current_year_price != NULL) {
                    $current_year_price = $value->current_year_price;
                }

                $todate_price = '';
                if ($value->todate_price != NULL) {
                    $todate_price = $value->todate_price;
                }

                $last_previous_years = '';
                if ($value->last_previous_years != NULL) {
                    $last_previous_years = $value->last_previous_years;
                }

                $last_previous_years_difference = '';
                if ($value->last_previous_years_difference != NULL) {
                    $last_previous_years_difference = $value->last_previous_years_difference;
                }

                $current_previous_years = '';
                if ($value->current_previous_years != NULL) {
                    $current_previous_years = $value->current_previous_years;
                }

                $current_previous_years_difference = '';
                if ($value->current_previous_years_difference != NULL) {
                    $current_previous_years_difference = $value->current_previous_years_difference;
                }
                $type = '';
                if ($value->type != NULL) {
                    $type = $value->type;
                }
                
                $innerArray = [
                    'currentYear'=>$currentYear,             
                    'country'=>$country,
                    'country_id'=>$countryId,
                    'selected_year'=>$selected_year,
                    'selected_month'=>$selected_month,
                    'current_year_price'=>$current_year_price,
                    'todate_price'=>$todate_price,
                    // 'lastYear_current_price'=> (count($lastMonthPreviousData['prevYearSaleTotalValues']) > 0) ? $lastMonthPreviousData['prevYearSaleTotalValues'][$key]->current_year_price:'',
                    // 'yearBeforelastYear_current_price'=> (count($lastMonthPreviousData['yearBeofrePrevYearSaleTotalValues']) > 0) ? $lastMonthPreviousData['yearBeofrePrevYearSaleTotalValues'][$key]->current_year_price:'',
                    'lastYear_current_price'=> '',
                    'yearBeforelastYear_current_price'=> '',
                    'last_previous_years'=>json_decode($last_previous_years),
                    'last_previous_years_difference'=> $last_previous_years_difference,
                    'current_previous_years'=> json_decode($current_previous_years),
                    'current_previous_years_difference'=> $current_previous_years_difference,
                    'type'=>$type
                ];
                
                if ($value->type == 'SELECTED_LAST_MONTH') {
                    if(!isset($dataArray[1]['dataset'])){
                        $dataArray[1]['dataset'] = array($innerArray);                        
                    }else{
                        array_push($dataArray[1]['dataset'], $innerArray);
                    }
                    $dataArray[1]['month'] = $selected_month;
                    
                }elseif ($value->type == 'ONE_TO_LAST') {
                    if(!isset($dataArray[2]['dataset'])){
                        $dataArray[2]['dataset'] = array($innerArray);                        
                    }else{
                        array_push($dataArray[2]['dataset'], $innerArray);
                    }
                    
                    $dataArray[2]['month'] = $selected_month;
                }else{
                    if(!isset($dataArray[3]['dataset'])){
                        $dataArray[3]['dataset'] = array($innerArray);                        
                    }else{
                        array_push($dataArray[3]['dataset'], $innerArray);
                    }
                    
                    $dataArray[3]['month'] = $selected_month;
                }
            }

            $innerArray = [
                'country'=>'',
                'country_id'=>'',
                'selected_year'=>$currentYear,
                'selected_month'=>$last_month,             
                'current_year_price'=>'',
                'todate_price'=>'',
                'lastYear_current_price'=> '',
                'yearBeforelastYear_current_price'=> '',
                'last_previous_years'=>array('0'=>$lastYear,'1'=>$prvLastYear),
                'last_previous_years_difference'=> '',
                'current_previous_years'=> array('0'=>$lastYear,'1'=>$currentYear),
                'current_previous_years_difference'=> '',
                'type'=>'ONE_TO_LAST'
            ];
            
            if ($dataArray[1]) {
                $innerArray['type'] = 'SELECTED_LAST_MONTH';
            } elseif ($dataArray[2]) {
                $innerArray['type'] = 'ONE_TO_LAST';
            } else{
                $innerArray['type'] = 'SECOND_TO_LAST';
            }            
            
            if (!isset($dataArray[1]['dataset'])) {
                $dataArray[1]['dataset'] = array($innerArray);
            }
            if (!isset($dataArray[2]['dataset'])) {
                $dataArray[2]['dataset'] = array($innerArray);
            }
            if (!isset($dataArray[3]['dataset'])) {
                $dataArray[3]['dataset'] = array($innerArray);
            }
            // $dataArray[1]['dataset'] = array($innerArray);
            // $dataArray[2]['dataset'] = array($innerArray);
            // $dataArray[3]['dataset'] = array($innerArray);
            
        } else {
            
            // '','ONE_TO_LAST','SECOND_TO_LAST'
            // if ($value->type == 'LAST_MONTH') {
            $innerArray = [
                'country'=>'',
                'country_id'=>'',
                'selected_year'=>$currentYear,
                'selected_month'=>$last_month,              
                'current_year_price'=>'',
                'todate_price'=>'',
                'lastYear_current_price'=> '',
                'yearBeforelastYear_current_price'=> '',
                'last_previous_years'=>array('0'=>$lastYear,'1'=>$prvLastYear),
                'last_previous_years_difference'=> '',
                'current_previous_years'=> array('0'=>$lastYear,'1'=>$currentYear),
                'current_previous_years_difference'=> '',
                'type'=>'ONE_TO_LAST'
            ];
            // }                
            // array_push($dataArray['type']['dataset'],$innerArray);  
            if ($dataArray[1]) {
                $innerArray['type'] = 'SELECTED_LAST_MONTH';
            } elseif ($dataArray[2]) {
                $innerArray['type'] = 'ONE_TO_LAST';
            } else{
                $innerArray['type'] = 'SECOND_TO_LAST';
            }
            
            $dataArray[1]['dataset'] = array($innerArray);
            $dataArray[2]['dataset'] = array($innerArray);
            $dataArray[3]['dataset'] = array($innerArray);
                            
        }

        // print_r($dataArray);
        // foreach ($dataArray as $key => $value) {            
        //     foreach ($value['dataset'] as $inner => $innervalue) {
        //         // print_r($innervalue);
        //     }
        //     print_r('<br><br>');
        // }
        
        return view('/tea-statistics/worldTeaProduction',[
                                                            'sale_code'=>$this->session_sale_code,
                                                            'currentMonth'=>$currentMonth,
                                                            'last_month'=>$last_month,                                                            
                                                            'oneToLast_month'=>$oneToLast_month,
                                                            'secondToLast_month'=>$secondToLast_month,
                                                            'currentYear'=>$currentYear,
                                                            'lastYear'=>$lastYear,
                                                            'prvLastYear'=>$prvLastYear,
                                                            'countries'=>$countries,
                                                            'months'=>$months,
                                                            // 'txtLastMonth'=>$txtLastMonth->name,
                                                            // 'txtoneToLast_month'=>$txtoneToLast_month->name,
                                                            // 'txtsecondToLast_month'=>$txtsecondToLast_month->name,
                                                            'dataArray'=>$dataArray
                                                        ]);
    }//fetchWorldTeaProductionDetails



    public function fetchWorldTeaProd(){
        
    }//fetchWorldTeaProd


    public function createWorldTeaProduction($detailArray){
        $message = 'Failed to add details!';
        $value = 0;
        $redirect = '';
        $result = 0;

        $res = world_tea_production::insert($detailArray);        

        if ($res) {
            $message = 'World Tea Production Details added successfully!';
            $value = 1;        
            
        } else {
            $message = 'World Tea Production Details are not added!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );        
    }//createWorldTeaProduction


    public function updateWorldTeaProduction($detailArray,$type){
        
        $message = 'Failed to update details!';
        $value = 0;
        $redirect = '';
        $result = 0;
        $idArr = array();

        $worldTeaDetails = world_tea_production::select('id')
                                    ->where('sales_code', '=',$this->session_sale_code)
                                    ->where('type', '=',$type)
                                    ->get();
                                    
        foreach ($worldTeaDetails as $key => $value) {            
            $idArr[] = $value->id;            
        }     

        $delete = world_tea_production::whereIn('id', $idArr)->delete();

        $res = world_tea_production::insert($detailArray);

        if ($res) {
            $message = 'World Tea Production Details added successfully!';
            $value = 1;        
            
        } else {
            $message = 'World Tea Production Details are not added!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );        
    }//updateWorldTeaProduction


    public function manipulateWorldTeaProductions(Request $request){        
        $status = array();
        $finalArray = array();

        $status['message'] = "Failed to update details!";
        $status['value'] = '0';
        $status['redirect'] = '';

        // $availability = $this->fetchDataSetBySaleCode(new world_tea_production(), 'sales_code', $this->session_sale_code);
        $availability = world_tea_production::select('id')
                                        ->where('sales_code', '=',$this->session_sale_code)
                                        ->where('type', '=',$request->type)
                                        ->get();

        foreach ($request->country as $key => $country) {
            // if (($request->last_month_current_year_val[$key] != NULL) | ($request->last_month_LP_val[$key] != NULL) | ($request->last_month_CL_val[$key] != NULL)) {
            array_push($finalArray, array(
                'sales_code'=>$this->session_sale_code,
                'country_id'=>$country,
                'selected_year'=>$request->first_current_year,
                'selected_month'=>$request->selected_month,
                'current_year_price'=>$request->current_year_value[$key],
                'todate_price'=>$request->todate_value[$key],
                'last_previous_years'=>'["'.$request->first_prvLastYear.'"],["'.$request->first_lastYear.'"]',
                'last_previous_years_difference'=> $request->last_previous_value[$key],
                'current_previous_years'=> '["'.$request->first_lastYear.'"],["'.$request->first_current_year.'"]',
                'current_previous_years_difference'=> $request->currenct_last_value[$key],
                'type'=>$request->type
            ));                
            // }                
        }

        if (count($availability) <= 0) {
            $status = $this->createWorldTeaProduction($finalArray);
        } else {
            $status = $this->updateWorldTeaProduction($finalArray,$request->type);
        }

        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);

    }//manipulateWorldTeaProductions

}
