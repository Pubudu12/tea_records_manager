<?php

namespace App\Http\Controllers;

use App\Http\Traits\DBOperationsTrait;
use App\Models\months;
use App\Models\reference_srilankan_tea_production;
use App\Models\sales_list;
use App\Models\srilankan_tea_production_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SriLankanTeaProductionController extends Controller
{
    use DBOperationsTrait;

    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');

            return $next($request);
        });
    }

    public function fetchYearList(){
        $yearList = array();
        $startYear = 2010;

        foreach (range(date('Y'), $startYear) as $year) {
            array_push($yearList,$year);
        }

        return ($yearList);
    }//fetchYearList


    public function fetchMonthList(){
        $monthList = $this->fetchData(new months());
        return $monthList;
    }//fetchMonthList
    

    public function fetchPreviousYearSaleData(){
        $currentData = DB::table('sales_list')
                            ->where('sales_code','=' ,$this->session_sale_code)
                            ->select('year','sales_no')
                            ->first();

        $currentYear = $currentData->year;
        $currentSaleNo = $currentData->sales_no;

        $prevYear = (int)$currentYear - 1;
        $prevSaleCode = $prevYear.'-'.$currentSaleNo;
        return $prevYearSaleTotalValues = DB::table('srilankan_tea_production_details')
                                        ->where('sale_code','=' ,$prevSaleCode)
                                        ->select('ctc_price','ctc_change_actual_price','ctc_change_percent_price',
                                            'orthodox_price','orthodox_change_actual_price','orthodox_change_percent_price',
                                            'total','total_change_actual_price','total_change_percent_price',)
                                        ->get();
    }//fetchPreviousYearSaleData


    public function getSriLankanTeaProductionDetails(){
        $references = $this->fetchData(new reference_srilankan_tea_production());
        $yearList = $this->fetchYearList();
        $monthList = $this->fetchMonthList();
        // $curntYear = $this->fetchDetailsBySalesCode(new sales_list(),'sales_code',$this->session_sale_code);

        $previousData = $this->fetchPreviousYearSaleData();   
        $currentData = DB::table('sales_list')
                            ->where('sales_code','=' ,$this->session_sale_code)
                            ->select('year','month')
                            ->first();
        
        $month = $currentData->month;
        $year = $currentData->year;        
        $lastYear = ((int)$year) - 1;
                
        $detailsArray = array();

        $dataSet = DB::table('srilankan_tea_production_details')
                        ->leftjoin('reference_srilankan_tea_production','reference_srilankan_tea_production.id','=','srilankan_tea_production_details.reference_tea_production_id')
                        ->where('srilankan_tea_production_details.sale_code', '=' ,$this->session_sale_code)
                        ->select('srilankan_tea_production_details.*','reference_srilankan_tea_production.name AS refname',
                                'reference_srilankan_tea_production.code AS refcode','reference_srilankan_tea_production.type',
                                'reference_srilankan_tea_production.id AS ref_id')
                        ->get();
        
        if (count($dataSet) <= 0) {
            foreach ($references as $key => $value) {       
                array_push($detailsArray,array(
                    'id'=>$value->id,
                    'name'=>$value->name,
                    'type'=>$value->type,
                    'lastYear_ctc_price'=> (count($previousData) > 0) ? $previousData[$key]->ctc_price:'',
                    'lastYear_orthodox_price'=> (count($previousData) > 0) ? $previousData[$key]->orthodox_price:'',
                    'ctc_price'=>'',
                    'ctc_change_actual_price'=>'',
                    'ctc_change_percent_price'=>'',
                    'orthodox_price'=>'',
                    'orthodox_change_actual_price'=>'',
                    'orthodox_change_percent_price'=>'',
                ));
            }
        } else {            
            foreach ($dataSet as $key => $value) {
                array_push($detailsArray,array(
                    'id'=>$value->ref_id,
                    'name'=>$value->refname,
                    'code'=>$value->refcode,
                    'type'=>$value->type,
                    'ctc_price'=>($value->ctc_price != NULL) ? number_format($value->ctc_price,2) :'',
                    'lastYear_ctc_price'=> (count($previousData) > 0) ? $previousData[$key]->ctc_price:'',
                    'lastYear_orthodox_price'=> (count($previousData) > 0) ? $previousData[$key]->orthodox_price:'',
                    'ctc_change_actual_price'=>($value->ctc_change_actual_price != NULL) ? number_format($value->ctc_change_actual_price,2): '',
                    'ctc_change_percent_price'=>($value->ctc_change_percent_price != NULL) ? number_format($value->ctc_change_percent_price,2):'',
                    'orthodox_price'=>($value->orthodox_price != NULL) ? number_format($value->orthodox_price,2):'',
                    'orthodox_change_actual_price'=>($value->orthodox_change_actual_price != NULL) ? number_format($value->orthodox_change_actual_price,2):'',
                    'orthodox_change_percent_price'=>($value->orthodox_change_percent_price != NULL) ? number_format($value->orthodox_change_percent_price,2):'',
                ));
            }
        }        
        
        return view('tea-statistics/sriLankaTeaProduction',['details'=>$detailsArray,'currentYear'=>$year,
                                                            'lastYear'=>$lastYear,'compareYears'=>$lastYear.'/'.$year,
                                                            'year'=>$year,'month'=>$month,'yearList'=>$yearList,'monthList'=>$monthList]);
    }//getSriLankanTeaProductionDetails


    public function createSriLankanTeaProduction($detailsArray){
        $message = 'Failed to add details!';
        $value = 0;
        $redirect = '';
        $result = 0;

        $prevDataArray = $this->fetchPreviousYearSaleData();

        for ($i=0; $i < count($detailsArray['ref_id']); $i++) { 

            $total = (float)$detailsArray['ctc_price'][$i] + (float)$detailsArray['orthodox_price'][$i];
            $totalChangeActual = (float)$detailsArray['ctc_change_actual_price'][$i] + (float)$detailsArray['orthodox_change_actual_price'][$i];
            $totalChangePercent = (float)$detailsArray['ctc_change_percent_price'][$i] + (float)$detailsArray['orthodox_change_percent_price'][$i];

            $ctc_price_status = $ctc_change_actual_status = $ctc_change_percent_status = $orthodox_status = $orthodox_change_actual_status = $orthodox_change_percent_status = $total_status = $total_change_actual_status = $total_change_percent_status = 'NO';
            if (count($prevDataArray) > 0) {
                $ctc_price_status = ($detailsArray['ctc_price'][$i] > $prevDataArray[$i]->ctc_price) ? "1" : (($detailsArray['ctc_price'][$i] < $prevDataArray[$i]->ctc_price) ? "0" : "NO");//(($detailsArray['ctc_price'][$i] > $prevDataArray[$i]->ctc_price) ? '1' : (($detailsArray['ctc_price'][$i] < $prevDataArray[$i]->ctc_price) ? '0' : 'NO'));
                $ctc_change_actual_status = ($detailsArray['ctc_change_actual_price'][$i] > $prevDataArray[$i]->ctc_change_actual_price) ? '1': (($detailsArray['ctc_change_actual_price'][$i] < $prevDataArray[$i]->ctc_change_actual_price) ? '0' : 'NO');
                $ctc_change_percent_status = ($detailsArray['ctc_change_percent_price'][$i] > $prevDataArray[$i]->ctc_change_percent_price) ? '1': (($detailsArray['ctc_change_percent_price'][$i] < $prevDataArray[$i]->ctc_change_percent_price) ? '0' : 'NO');
                $orthodox_status = ($detailsArray['orthodox_price'][$i] > $prevDataArray[$i]->orthodox_price) ? '1': (($detailsArray['orthodox_price'][$i] < $prevDataArray[$i]->orthodox_price) ? '0' : 'NO');
                $orthodox_change_actual_status = ($detailsArray['orthodox_change_actual_price'][$i] > $prevDataArray[$i]->orthodox_change_actual_price) ? '1': (($detailsArray['orthodox_change_actual_price'][$i] < $prevDataArray[$i]->orthodox_change_actual_price) ? '0': 'NO');
                $orthodox_change_percent_status = ($detailsArray['orthodox_change_percent_price'][$i] > $prevDataArray[$i]->orthodox_change_percent_price) ? '1': (($detailsArray['orthodox_change_percent_price'][$i] < $prevDataArray[$i]->orthodox_change_percent_price) ? '0' :'NO');
                $total_status = ($total > $prevDataArray[$i]->total)? '1': (($total < $prevDataArray[$i]->total) ? '0': 'NO');
                $total_change_actual_status = ($totalChangeActual > $prevDataArray[$i]->total_change_actual_price) ? '1': (($totalChangeActual < $prevDataArray[$i]->total_change_actual_price)?'0':'NO');
                $total_change_percent_status = ($totalChangePercent > $prevDataArray[$i]->total_change_percent_price) ? '1': (($totalChangePercent < $prevDataArray[$i]->total_change_percent_price) ? '0' : 'NO');
            }
            // credits < 30 ? "freshman" : credits <= 59 ? "sophomore" : credits <= 89 ? "junior" : "senior";
            $result = srilankan_tea_production_details::create([
                'reference_tea_production_id' => $detailsArray['ref_id'][$i],
                'sale_code'=>$this->session_sale_code,
                'year'=>$detailsArray['currentYear'],
                'month'=>$detailsArray['month'],
                'comparing_years'=>'["'.$detailsArray['lastYear'].'","'.$detailsArray['currentYear'].'"]',
                'ctc_price' => ($detailsArray['ctc_price'][$i] != NULL)? floatval(preg_replace('/[^\d.-]/', '',$detailsArray['ctc_price'][$i])): NULL,
                'ctc_change_actual_price' => ($detailsArray['ctc_change_actual_price'][$i] !=NULL)? floatval(preg_replace('/[^\d.-]/', '',$detailsArray['ctc_change_actual_price'][$i])): NULL,
                'ctc_change_percent_price'=> ($detailsArray['ctc_change_percent_price'][$i] !=NULL)? floatval(preg_replace('/[^\d.-]/', '',$detailsArray['ctc_change_percent_price'][$i])): NULL,
                'orthodox_price'=> ($detailsArray['orthodox_price'][$i] !=NULL)? floatval(preg_replace('/[^\d.-]/', '',$detailsArray['orthodox_price'][$i])): NULL,
                'orthodox_change_actual_price'=> ($detailsArray['orthodox_change_actual_price'][$i] !=NULL)? floatval(preg_replace('/[^\d.-]/', '',$detailsArray['orthodox_change_actual_price'][$i])): NULL,
                'orthodox_change_percent_price'=> ($detailsArray['orthodox_change_percent_price'][$i] !=NULL)? floatval(preg_replace('/[^\d.-]/', '',$detailsArray['orthodox_change_percent_price'][$i])): NULL,
                'total'=>$total,
                'total_change_actual_price'=>$totalChangeActual,
                'total_change_percent_price'=>$totalChangePercent,
                'ctc_price_status' => $ctc_price_status,
                'ctc_change_actual_status'=>$ctc_change_actual_status,
                'ctc_change_percent_status'=>$ctc_change_percent_status,
                'orthodox_status'=>$orthodox_status,
                'orthodox_change_actual_status'=>$orthodox_change_actual_status,
                'orthodox_change_percent_status'=>$orthodox_change_percent_status,
                'total_status'=>$total_status,
                'total_change_actual_status'=>$total_change_actual_status,
                'total_change_percent_status'=>$total_change_percent_status
            ]);      
        }          
           

        if ($result) {
            $message = 'Sri Lankan Tea Production Details added successfully!';
            $value = 1;        
            
        } else {
            $message = 'Sri Lankan Tea Production Details are not added!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );        
    }//createSriLankanTeaProduction


    public function updateSriLankanTeaProduction($detailsArray){
        $message = 'Failed to update details!';
        $value = 0;
        $redirect = '';
        $result = 0;

        $deleteDetails = DB::table('srilankan_tea_production_details')
                            ->where('sale_code', '=' ,$this->session_sale_code)
                            ->delete();
        

        if ($deleteDetails) {

            $prevDataArray = $this->fetchPreviousYearSaleData();
            
            for ($i=0; $i < count($detailsArray['ref_id']); $i++) { 

                $total = (float)$detailsArray['ctc_price'][$i] + (float)$detailsArray['orthodox_price'][$i];
                $totalChangeActual = (float)$detailsArray['ctc_change_actual_price'][$i] + (float)$detailsArray['orthodox_change_actual_price'][$i];
                $totalChangePercent = (float)$detailsArray['ctc_change_percent_price'][$i] + (float)$detailsArray['orthodox_change_percent_price'][$i];

                $ctc_price_status = $ctc_change_actual_status = $ctc_change_percent_status = $orthodox_status = $orthodox_change_actual_status = $orthodox_change_percent_status = $total_status = $total_change_actual_status = $total_change_percent_status = 'NO';
                if (count($prevDataArray) > 0) {
                    
                    $ctc_price_status = ($detailsArray['ctc_price'][$i] > $prevDataArray[$i]->ctc_price) ? "1" : (($detailsArray['ctc_price'][$i] < $prevDataArray[$i]->ctc_price) ? "0" : "NO");
                    $ctc_change_actual_status = ($detailsArray['ctc_change_actual_price'][$i] > $prevDataArray[$i]->ctc_change_actual_price) ? '1': (($detailsArray['ctc_change_actual_price'][$i] < $prevDataArray[$i]->ctc_change_actual_price) ? '0' : 'NO');
                    $ctc_change_percent_status = ($detailsArray['ctc_change_percent_price'][$i] > $prevDataArray[$i]->ctc_change_percent_price) ? '1': (($detailsArray['ctc_change_percent_price'][$i] < $prevDataArray[$i]->ctc_change_percent_price) ? '0' : 'NO');
                    $orthodox_status = ($detailsArray['orthodox_price'][$i] > $prevDataArray[$i]->orthodox_price) ? '1': (($detailsArray['orthodox_price'][$i] < $prevDataArray[$i]->orthodox_price) ? '0' : 'NO');
                    $orthodox_change_actual_status = ($detailsArray['orthodox_change_actual_price'][$i] > $prevDataArray[$i]->orthodox_change_actual_price) ? '1': (($detailsArray['orthodox_change_actual_price'][$i] < $prevDataArray[$i]->orthodox_change_actual_price) ? '0': 'NO');
                    $orthodox_change_percent_status = ($detailsArray['orthodox_change_percent_price'][$i] > $prevDataArray[$i]->orthodox_change_percent_price) ? '1': (($detailsArray['orthodox_change_percent_price'][$i] < $prevDataArray[$i]->orthodox_change_percent_price) ? '0' :'NO');
                    $total_status = ($total > $prevDataArray[$i]->total)? '1': (($total < $prevDataArray[$i]->total) ? '0': 'NO');
                    $total_change_actual_status = ($totalChangeActual > $prevDataArray[$i]->total_change_actual_price) ? '1': (($totalChangeActual < $prevDataArray[$i]->total_change_actual_price)?'0':'NO');
                    $total_change_percent_status = ($totalChangePercent > $prevDataArray[$i]->total_change_percent_price) ? '1': (($totalChangePercent < $prevDataArray[$i]->total_change_percent_price) ? '0' : 'NO');
                }
                
                $result = srilankan_tea_production_details::create([
                    'reference_tea_production_id' => $detailsArray['ref_id'][$i],
                    'sale_code'=>$this->session_sale_code,
                    'year'=>$detailsArray['currentYear'],
                    'month'=>$detailsArray['month'],
                    'comparing_years'=>'["'.$detailsArray['lastYear'].'","'.$detailsArray['currentYear'].'"]',
                    'ctc_price' => ($detailsArray['ctc_price'][$i] !=NULL)? floatval(preg_replace('/[^\d.-]/', '',$detailsArray['ctc_price'][$i])): NULL,
                    'ctc_change_actual_price' => ($detailsArray['ctc_change_actual_price'][$i] !=NULL)? floatval(preg_replace('/[^\d.-]/', '',$detailsArray['ctc_change_actual_price'][$i])): NULL,
                    'ctc_change_percent_price'=> ($detailsArray['ctc_change_percent_price'][$i] !=NULL)? floatval(preg_replace('/[^\d.-]/', '',$detailsArray['ctc_change_percent_price'][$i])): NULL,
                    'orthodox_price'=> ($detailsArray['orthodox_price'][$i] !=NULL)? floatval(preg_replace('/[^\d.-]/', '',$detailsArray['orthodox_price'][$i])): NULL,
                    'orthodox_change_actual_price'=> ($detailsArray['orthodox_change_actual_price'][$i] !=NULL)? floatval(preg_replace('/[^\d.-]/', '',$detailsArray['orthodox_change_actual_price'][$i])): NULL,
                    'orthodox_change_percent_price'=> ($detailsArray['orthodox_change_percent_price'][$i] !=NULL)? floatval(preg_replace('/[^\d.-]/', '',$detailsArray['orthodox_change_percent_price'][$i])): NULL,
                    'total'=>$total,
                    'total_change_actual_price'=>$totalChangeActual,
                    'total_change_percent_price'=>$totalChangePercent,
                    'ctc_price_status' => $ctc_price_status,
                    'ctc_change_actual_status'=>$ctc_change_actual_status,
                    'ctc_change_percent_status'=>$ctc_change_percent_status,
                    'orthodox_status'=>$orthodox_status,
                    'orthodox_change_actual_status'=>$orthodox_change_actual_status,
                    'orthodox_change_percent_status'=>$orthodox_change_percent_status,
                    'total_status'=>$total_status,
                    'total_change_actual_status'=>$total_change_actual_status,
                    'total_change_percent_status'=>$total_change_percent_status
                ]);                
            }     
        }  

        if ($result) {
            $message = 'Sri Lankan Tea Production Details updated successfully!';
            $value = 1;        
            
        } else {
            $message = 'Sri Lankan Tea Production Details are not updated!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );   
    }//updateSriLankanTeaProduction


    public function manipulateSriLankanTeaProductionData(Request $request){
        $status = array();

        $availability = $this->fetchDataSetBySaleCode(new srilankan_tea_production_details(), 'sale_code', $this->session_sale_code);
        $detailArray = array('ref_id'=>$request->ref_id,
                            'ctc_price'=>$request->ctc_price,'ctc_change_actual_price'=>$request->ctc_change_actual_price,
                            'ctc_change_percent_price'=>$request->ctc_change_percent_price,'orthodox_price'=>$request->orthodox_price,
                            'orthodox_change_actual_price'=>$request->orthodox_change_actual_price,
                            'orthodox_change_percent_price'=>$request->orthodox_change_percent_price,
                            'lastYear'=>$request->lastYear,'currentYear'=>$request->currentYear,'month'=>$request->month
                            );

        if (count($availability) <= 0) {
            $status = $this->createSriLankanTeaProduction($detailArray);
        } else {
            $status = $this->updateSriLankanTeaProduction($detailArray);
        }
        
        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);
    }//manipulateSriLankanTeaProductionData
}
