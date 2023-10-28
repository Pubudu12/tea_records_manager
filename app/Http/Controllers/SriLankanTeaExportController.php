<?php

namespace App\Http\Controllers;

use App\Http\Traits\DBOperationsTrait;
use App\Models\months;
use App\Models\reference_srilankan_tea_exports;
use App\Models\sales_list;
use App\Models\sri_lanka_tea_export_main;
use App\Models\srilankan_tea_exports_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SriLankanTeaExportController extends Controller
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

    public function getSriLankaTeaExports(){

        $exportArray = array();
        $refExports = $this->fetchData(new reference_srilankan_tea_exports());
        // $exportDetails = $this->fetchDataSetBySaleCode(new srilankan_tea_exports_details(), 'sale_code', $this->session_sale_code);

        $exportDetailsMain = DB::table('sri_lanka_tea_export_main')
                                ->where('sri_lanka_tea_export_main.sale_code','=', $this->session_sale_code)
                                ->select('sri_lanka_tea_export_main.*')
                                ->first();
        
        if ($exportDetailsMain != NULL) {   
            $main_id = $exportDetailsMain->id;         
            $exportArray = array(
                'main_id' => $main_id,
                'source' => $exportDetailsMain->source,
                'date' => date('Y-m-d',strtotime($exportDetailsMain->date)),
            );

            $exportArray['detalis'] = array();
            
            $exportDetails = DB::table('srilankan_tea_exports_details')
                                ->leftjoin('sri_lanka_tea_export_main','sri_lanka_tea_export_main.id','=','srilankan_tea_exports_details.tea_export_main_id')
                                ->leftjoin('reference_srilankan_tea_exports','reference_srilankan_tea_exports.id','=','srilankan_tea_exports_details.reference_srilankan_tea_exports_id')
                                ->where('srilankan_tea_exports_details.tea_export_main_id','=', $main_id)
                                ->where('sri_lanka_tea_export_main.sale_code','=', $this->session_sale_code)
                                ->select('srilankan_tea_exports_details.*','reference_srilankan_tea_exports.name AS refName','reference_srilankan_tea_exports.code AS refcode','reference_srilankan_tea_exports.id AS refId')
                                ->get();

            
                foreach ($exportDetails as $key => $singleExport) {
                    array_push($exportArray['detalis'],array(
                        'id' => $singleExport->reference_srilankan_tea_exports_id,
                        'ref_name' => $singleExport->refName,
                        'v_price' => ($singleExport->v_price != NULL) ? number_format($singleExport->v_price,2) : '',
                        'value_price' => ($singleExport->value_price != NULL) ? number_format($singleExport->value_price,2) : '',
                        'approx_price' => ($singleExport->approx_price != NULL) ? number_format($singleExport->approx_price,2) : '',                    
                        'type'=>$singleExport->refcode
                    ));
                }
        } else {
            $exportArray = array(
                'main_id' => '0',
                'source' => '',
                'date' => date('Y-m-d'),
            );

            $exportArray['detalis'] = array();
            foreach ($refExports as $key => $singleExport) {
                array_push($exportArray['detalis'],array(
                    'id' => $singleExport->id,
                    'ref_name' => $singleExport->name,
                    'v_price' => '',
                    'value_price' => '',
                    'approx_price' => '',
                    'type'=>$singleExport->code
                ));
            }
        }

        $yearList = $this->fetchYearList();
        $monthList = $this->fetchMonthList();

        $fetchsalesDetails = $this->fetchDetailsBySalesCode(new sales_list(), 'sales_code', $this->session_sale_code);
        return view('tea-statistics/sriLankaTeaExporters',['exportDetails'=>$exportArray,'saleDetails'=>$fetchsalesDetails,'months'=>$monthList,'years'=>$yearList]);
    }//getSriLankaTeaExports


    public function createSriLankanTeaExport($detailArray){
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;
        
        $details = new sri_lanka_tea_export_main();

        $details->sale_code = $this->session_sale_code;
        $details->source = $detailArray['source'];
        $details->date = $detailArray['exportDate'];

        $res = $details->save();

        if ($res) {
            $latest_id = DB::table('sri_lanka_tea_export_main')->orderBy('id', 'desc')->value('id');
            
            if ($detailArray['ref_id'] != NULL) {
                for ($i=0; $i < count($detailArray['ref_id']); $i++) { 
                    $vprice = NULL;
                    $value_price = NULL;
                    $approx_price = NULL;
                    if ($detailArray['v_priceArr'][$i] != NULL) {
                        $vprice = floatval(preg_replace('/[^\d.-]/', '', $detailArray['v_priceArr'][$i]));
                    }

                    if ($detailArray['value_priceArr'][$i] != NULL) {
                        $value_price = floatval(preg_replace('/[^\d.-]/', '', $detailArray['value_priceArr'][$i]));
                    }

                    if ($detailArray['approx_priceArr'][$i] != NULL) {
                        $approx_price = floatval(preg_replace('/[^\d.-]/', '', $detailArray['approx_priceArr'][$i]));
                    }
                                        
                    $result = srilankan_tea_exports_details::create([
                        'reference_srilankan_tea_exports_id' => $detailArray['ref_id'][$i],
                        'tea_export_main_id' => $latest_id,
                        'v_price' => $vprice,
                        'value_price' => $value_price,
                        'approx_price'=> $approx_price,
                    ]);
                }          
            } 
        }

        if ($result) {
            $message = 'Sri Lanka Tea Exports added successfully!';
            $value = 1;        
            
        } else {
            $message = 'Sri Lanka Tea Exports are not added!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );        
     
    }//createSriLankanTeaExport


    public function updateSriLankanTeaExport($detailArray){
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;        
        
        $main = sri_lanka_tea_export_main::select('*')
                            ->where('id', '=', $detailArray['main_id'])
                            ->where('sale_code', '=', $this->session_sale_code)
                            ->first();
        
        $main->source = $detailArray['source'];
        $main->date = $detailArray['exportDate'];
        $res = $main->save();

        if ($res) {

            $details = srilankan_tea_exports_details::select('*')
                            ->where('tea_export_main_id', '=', $detailArray['main_id'])
                            ->get();

            foreach ($details as $key => $value) {
                $res = $value->delete(); 
            }

            // $numbers = $this->sanitizeNumbers(array($detailArray['v_priceArr'],$detailArray['value_priceArr'],$detailArray['approx_priceArr']));
            
            if ($detailArray['ref_id'] != NULL) {
                for ($i=0; $i < count($detailArray['ref_id']); $i++) { 

                    $vprice = NULL;
                    $value_price = NULL;
                    $approx_price = NULL;
                    if ($detailArray['v_priceArr'][$i] != NULL) {
                        $vprice = floatval(preg_replace('/[^\d.-]/', '', $detailArray['v_priceArr'][$i]));
                    }

                    if ($detailArray['value_priceArr'][$i] != NULL) {
                        $value_price = floatval(preg_replace('/[^\d.-]/', '', $detailArray['value_priceArr'][$i]));
                    }

                    if ($detailArray['approx_priceArr'][$i] != NULL) {
                        $approx_price = floatval(preg_replace('/[^\d.-]/', '', $detailArray['approx_priceArr'][$i]));
                    }
                    
                    $result = srilankan_tea_exports_details::create([
                        'reference_srilankan_tea_exports_id' => $detailArray['ref_id'][$i],
                        'tea_export_main_id' => $detailArray['main_id'],
                        'v_price' => $vprice,
                        'value_price' => $value_price,
                        'approx_price'=> $approx_price,
                    ]);
                }          
            } 
        }

        if ($result) {
            $message = 'Sri Lanka Tea Exports updated successfully!';
            $value = 1;        
            
        } else {
            $message = 'Sri Lanka Tea Exports are not updated!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );        
    }//updateSriLankanTeaExport


    public function manipulateSriLankaTeaExports(Request $request){
        $filedName = 'sale_code';
        $status = array();

        $v_priceArr = $request->v_price;
        $value_priceArr = $request->value_price;
        $approx_priceArr = $request->approx_price;
        $refArr = $request->ref_id;

        $availability = $this->fetchDetailsBySalesCode(new sri_lanka_tea_export_main(), 'sale_code', $this->session_sale_code);
        $detailArray = array('ref_id'=>$refArr,'v_priceArr'=>$v_priceArr,'value_priceArr'=>$value_priceArr,
                                'approx_priceArr'=>$approx_priceArr,'source'=>$request->source,
                                'main_id'=>$request->main_id,'exportDate'=>$request->exportDate);

        if ($availability == NULL) {
            $status = $this->createSriLankanTeaExport($detailArray);
        } else {
            $status = $this->updateSriLankanTeaExport($detailArray);
        }
        
        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);

    }//manipulateSriLankaTeaExports
}
