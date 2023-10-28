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

        // $prevYearSaleTotalValues = array();
        // $yearBeforePrevYearSaleTotalValues = array();

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

        $yearBeforePrevYearSaleTotalValues = world_tea_production::select('current_year_price')
                                                    ->where('sales_code', '=',$yearBeforePrevSaleCode)
                                                    ->where('type', '=', $type)
                                                    ->get();

        return array('yearBeforePrevYearSaleTotalValues'=>$yearBeforePrevYearSaleTotalValues,'prevYearSaleTotalValues'=>$prevYearSaleTotalValues);

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

        $dataArray[1]['name'] = 'SELECTED_LAST_MONTH';
        $dataArray[2]['name'] = 'ONE_TO_LAST';
        $dataArray[3]['name'] = 'SECOND_TO_LAST'; 

        if (count($lastMonthData) > 0) {
            $innerArray = array();                   

            foreach ($lastMonthData as $key => $value) {
                $lastMonthPreviousData = $this->fetchPreviousSaleData($this->session_sale_code,$value->type); 
                // print_r($lastMonthPreviousData);
                // print_r('<br><br>');
                $innerArray = [
                    'currentYear'=>$currentYear,          
                    'country'=>$value->name,
                    'country_id'=>$value->country_id,
                    'selected_year'=>$value->selected_year,
                    'selected_month'=>$value->selected_month,
                    'current_year_price'=>$value->current_year_price,
                    'lastYear_current_price'=> (count($lastMonthPreviousData['prevYearSaleTotalValues']) > 0) ? $lastMonthPreviousData['prevYearSaleTotalValues'][$key]->current_year_price:'',
                    'yearBeforelastYear_current_price'=> (count($lastMonthPreviousData['yearBeforePrevYearSaleTotalValues']) > 0) ? $lastMonthPreviousData['yearBeforePrevYearSaleTotalValues'][$key]->current_year_price:'',
                    'last_previous_years'=>json_decode($value->last_previous_years),
                    'last_previous_years_difference'=> $value->last_previous_years_difference,
                    'current_previous_years'=> json_decode($value->current_previous_years),
                    'current_previous_years_difference'=> $value->current_previous_years_difference,
                    'type'=>$value->type
                ];

                if ($value->type == 'SELECTED_LAST_MONTH') {
                    if(isset($dataArray[1]['dataset'])){
                        array_push($dataArray[1]['dataset'], $innerArray);
                    }else{
                        $dataArray[1]['dataset'] = array($innerArray);
                    }
                    
                }elseif ($value->type == 'ONE_TO_LAST') {
                    if(isset($dataArray[2]['dataset'])){
                        array_push($dataArray[2]['dataset'], $innerArray);
                    }else{
                        $dataArray[2]['dataset'] = array($innerArray);
                    }
                }else{
                    if(isset($dataArray[3]['dataset'])){
                        array_push($dataArray[3]['dataset'], $innerArray);
                    }else{
                        $dataArray[3]['dataset'] = array($innerArray);
                    }
                }
            }                
        } else {

            $innerArray = [
                'country'=>'',
                'country_id'=>'',
                'selected_year'=>$currentYear,
                'selected_month'=>$last_month,                
                'current_year_price'=>'',
                'lastYear_current_price'=> '',
                'yearBeforelastYear_current_price'=> '',
                'last_previous_years'=>array('0'=>$lastYear,'1'=>$prvLastYear),
                'last_previous_years_difference'=> '',
                'current_previous_years'=> array('0'=>$lastYear,'1'=>$currentYear),
                'current_previous_years_difference'=> '',
                'type'=>''
            ];
            $lastMonthPreviousData = $this->fetchPreviousSaleData($this->session_sale_code,'SELECTED_LAST_MONTH'); 
            $onetolastMonthPreviousData = $this->fetchPreviousSaleData($this->session_sale_code,'ONE_TO_LAST');
            $secToMonthPreviousData = $this->fetchPreviousSaleData($this->session_sale_code,'SECOND_TO_LAST');

            $innerArray['type'] = 'SELECTED_LAST_MONTH';
            $dataArray[1]['dataset'] = array($innerArray);
            $dataArray[2]['dataset'] = array($innerArray);
            $dataArray[3]['dataset'] = array($innerArray);
            // if ((isset($lastMonthPreviousData['yearBeforePrevYearSaleTotalValues'])) | (isset($lastMonthPreviousData['prevYearSaleTotalValues']))) {
            //     print_r('called');
            //     foreach ($lastMonthPreviousData as $key => $value) {
            //         $innerArray = [
            //             'country'=>'',
            //             'country_id'=>'',
            //             'selected_year'=>$currentYear,
            //             'selected_month'=>$last_month,                
            //             'current_year_price'=>'',
            //             'lastYear_current_price'=> (count($lastMonthPreviousData['prevYearSaleTotalValues']) > 0) ? $lastMonthPreviousData['prevYearSaleTotalValues'][$key]->current_year_price:'',
            //             'yearBeforelastYear_current_price'=> (count($value['yearBeforePrevYearSaleTotalValues']) > 0) ? $value['yearBeforePrevYearSaleTotalValues'][$key]->current_year_price:'',
            //             'last_previous_years'=>array('0'=>$lastYear,'1'=>$prvLastYear),
            //             'last_previous_years_difference'=> '',
            //             'current_previous_years'=> array('0'=>$lastYear,'1'=>$currentYear),
            //             'current_previous_years_difference'=> '',
            //             'type'=>'SELECTED_LAST_MONTH'
            //         ];

            //         if ($value->type == 'SELECTED_LAST_MONTH') {
            //             if(isset($dataArray[1]['dataset'])){
            //                 array_push($dataArray[1]['dataset'], $innerArray);
            //             }else{
            //                 $dataArray[1]['dataset'] = array($innerArray);
            //             }
                        
            //         }elseif ($value->type == 'ONE_TO_LAST') {
            //             if(isset($dataArray[2]['dataset'])){
            //                 array_push($dataArray[2]['dataset'], $innerArray);
            //             }else{
            //                 $dataArray[2]['dataset'] = array($innerArray);
            //             }
            //         }else{
            //             if(isset($dataArray[3]['dataset'])){
            //                 array_push($dataArray[3]['dataset'], $innerArray);
            //             }else{
            //                 $dataArray[3]['dataset'] = array($innerArray);
            //             }
            //         }
            //     }                
            // }else {
            //     print_r('cbnxmzbcnmxbnm');
            //     $innerArray['type'] = 'SELECTED_LAST_MONTH';
            //     $dataArray[1]['dataset'] = array($innerArray);
            //     $dataArray[2]['dataset'] = array($innerArray);
            //     $dataArray[3]['dataset'] = array($innerArray);
            // }

            // if ((count($onetolastMonthPreviousData['yearBeforePrevYearSaleTotalValues']) > 0) | (count($onetolastMonthPreviousData['prevYearSaleTotalValues']) > 0)) {
            //     foreach ($onetolastMonthPreviousData as $key => $value) {
            //         $innerArray = [
            //             'country'=>'',
            //             'country_id'=>'',
            //             'selected_year'=>$currentYear,
            //             'selected_month'=>$last_month,                
            //             'current_year_price'=>'',
            //             'lastYear_current_price'=> (count($onetolastMonthPreviousData['prevYearSaleTotalValues']) > 0) ? $onetolastMonthPreviousData['prevYearSaleTotalValues'][$key]->current_year_price:'',
            //             'yearBeforelastYear_current_price'=> (count($onetolastMonthPreviousData['yearBeforePrevYearSaleTotalValues']) > 0) ? $onetolastMonthPreviousData['yearBeforePrevYearSaleTotalValues'][$key]->current_year_price:'',
            //             'last_previous_years'=>array('0'=>$lastYear,'1'=>$prvLastYear),
            //             'last_previous_years_difference'=> '',
            //             'current_previous_years'=> array('0'=>$lastYear,'1'=>$currentYear),
            //             'current_previous_years_difference'=> '',
            //             'type'=>'ONE_TO_LAST'
            //         ];
            //         if ($value->type == 'SELECTED_LAST_MONTH') {
            //             if(isset($dataArray[1]['dataset'])){
            //                 array_push($dataArray[1]['dataset'], $innerArray);
            //             }else{
            //                 $dataArray[1]['dataset'] = array($innerArray);
            //             }
                        
            //         }elseif ($value->type == 'ONE_TO_LAST') {
            //             if(isset($dataArray[2]['dataset'])){
            //                 array_push($dataArray[2]['dataset'], $innerArray);
            //             }else{
            //                 $dataArray[2]['dataset'] = array($innerArray);
            //             }
            //         }else{
            //             if(isset($dataArray[3]['dataset'])){
            //                 array_push($dataArray[3]['dataset'], $innerArray);
            //             }else{
            //                 $dataArray[3]['dataset'] = array($innerArray);
            //             }
            //         }
            //     }                
            // }else {
            //     $innerArray['type'] = 'ONE_TO_LAST';
            //     $dataArray[1]['dataset'] = array($innerArray);
            //     $dataArray[2]['dataset'] = array($innerArray);
            //     $dataArray[3]['dataset'] = array($innerArray);
            // }

            // if ((count($secToMonthPreviousData['yearBeforePrevYearSaleTotalValues']) > 0) | (count($secToMonthPreviousData['prevYearSaleTotalValues']) > 0)) {
            //     foreach ($secToMonthPreviousData as $key => $value) {
            //         $innerArray = [
            //             'country'=>'',
            //             'country_id'=>'',
            //             'selected_year'=>$currentYear,
            //             'selected_month'=>$last_month,                
            //             'current_year_price'=>'',
            //             'lastYear_current_price'=> (count($secToMonthPreviousData['prevYearSaleTotalValues']) > 0) ? $secToMonthPreviousData['prevYearSaleTotalValues'][$key]->current_year_price:'',
            //             'yearBeforelastYear_current_price'=> (count($secToMonthPreviousData['yearBeforePrevYearSaleTotalValues']) > 0) ? $secToMonthPreviousData['yearBeforePrevYearSaleTotalValues'][$key]->current_year_price:'',
            //             'last_previous_years'=>array('0'=>$lastYear,'1'=>$prvLastYear),
            //             'last_previous_years_difference'=> '',
            //             'current_previous_years'=> array('0'=>$lastYear,'1'=>$currentYear),
            //             'current_previous_years_difference'=> '',
            //             'type'=>'SECOND_TO_LAST'
            //         ];
            //         if ($value->type == 'SELECTED_LAST_MONTH') {
            //             if(isset($dataArray[1]['dataset'])){
            //                 array_push($dataArray[1]['dataset'], $innerArray);
            //             }else{
            //                 $dataArray[1]['dataset'] = array($innerArray);
            //             }
                        
            //         }elseif ($value->type == 'ONE_TO_LAST') {
            //             if(isset($dataArray[2]['dataset'])){
            //                 array_push($dataArray[2]['dataset'], $innerArray);
            //             }else{
            //                 $dataArray[2]['dataset'] = array($innerArray);
            //             }
            //         }else{
            //             if(isset($dataArray[3]['dataset'])){
            //                 array_push($dataArray[3]['dataset'], $innerArray);
            //             }else{
            //                 $dataArray[3]['dataset'] = array($innerArray);
            //             }
            //         }
            //     }                
            // }else {
            //     $innerArray['type'] = 'SECOND_TO_LAST';
            //     $dataArray[1]['dataset'] = array($innerArray);
            //     $dataArray[2]['dataset'] = array($innerArray);
            //     $dataArray[3]['dataset'] = array($innerArray);
            // }
        }

        // print_r($dataArray);
        foreach ($dataArray as $key => $value) {
            
            foreach ($value['dataset'] as $inner => $innervalue) {
                print_r($innervalue);
            }            
        }
        
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
                                                            'txtLastMonth'=>$txtLastMonth->name,
                                                            'txtoneToLast_month'=>$txtoneToLast_month->name,
                                                            'txtsecondToLast_month'=>$txtsecondToLast_month->name,
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


    public function updateWorldTeaProduction($detailArray){
        $message = 'Failed to update details!';
        $value = 0;
        $redirect = '';
        $result = 0;

        $ids = world_tea_production::select('id')
                                        ->where('sales_code', '=',$this->session_sale_code)
                                        ->get();  

        foreach ($ids as $key => $value) {
            $idArr[] = $value['id'];
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

        $availability = $this->fetchDataSetBySaleCode(new world_tea_production(), 'sales_code', $this->session_sale_code);

        print_r($request->country);
               
        foreach ($request->country as $key => $country) {
            // if (($request->last_month_current_year_val[$key] != NULL) | ($request->last_month_LP_val[$key] != NULL) | ($request->last_month_CL_val[$key] != NULL)) {
                array_push($finalArray, array(
                    'sales_code'=>$this->session_sale_code,
                    'country_id'=>$country,
                    'selected_year'=>$request->first_current_year,
                    'selected_month'=>$request->last_month,
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
        
        foreach ($finalArray as $key => $value) {
            print_r($value);
            print_r('<br><br>');
        }

        if (count($availability) <= 0) {
            $status = $this->createWorldTeaProduction($finalArray);
        } else {
            $status = $this->updateWorldTeaProduction($finalArray);
        }
        
        $status['message'] = "World Tea Production details updated successfully!";
        $status['value'] = 1;
        $status['redirect'] = '';

        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);

    }//manipulateWorldTeaProductions

}
