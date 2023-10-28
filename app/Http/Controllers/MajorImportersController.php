<?php

namespace App\Http\Controllers;

use App\Http\Traits\DBOperationsTrait;
use App\Models\import_countries;
use App\Models\major_importers_details;
use App\Models\major_importers_main;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MajorImportersController extends Controller
{
    use DBOperationsTrait;
    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');

            return $next($request);
        });
    }


    public function getImporters(){
        $countries = $this->fetchData(new import_countries());

        $mainDetails = $this->fetchDetailsBySalesCode(new major_importers_main() ,'sales_code' , $this->session_sale_code);

        $updatedDetails = DB::table('major_importers_main')
                            ->leftjoin('major_importers_details','major_importers_details.importers_main_id','=','major_importers_main.id')
                            ->leftjoin('import_countries','import_countries.id','=','major_importers_details.country_id')
                            ->where('major_importers_main.sales_code', '=' ,$this->session_sale_code)
                            ->select('major_importers_details.*','import_countries.name AS country')
                            ->get();

        return view('tea-statistics/majorTeaImportesSriLanka',['countries'=>$countries,'main'=>$mainDetails,'updatedDetails'=>$updatedDetails]);
    }//getImporters


    public function fetchPreviousYearSaleData(){
        $currentData = DB::table('sales_list')
                ->where('sales_code','=' ,$this->session_sale_code)
                ->select('year','sales_no')
                ->first();

        $currentYear = $currentData->year;
        $currentSaleNo = $currentData->sales_no;

        $prevYear = (int)$currentYear - 1;
        $prevSaleCode = $prevYear.'-'.$currentSaleNo;
        return $prevYearSaleTotalValues = DB::table('major_importers_main')
                                        ->leftjoin('major_importers_details','major_importers_details.importers_main_id','=','major_importers_main.id')
                                        ->where('major_importers_main.sales_code','=' ,$prevSaleCode)
                                        ->select('major_importers_details.total')
                                        ->get();
    }//fetchPreviousYearSaleData


    public function createMajorImporters($detailsArray){
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;
        
        $details = new major_importers_main();

        $details->sales_code = $this->session_sale_code;
        $details->source = $detailsArray['source'];

        $res = $details->save();

        if ($res) {
            $latest_id = DB::table('major_importers_main')->orderBy('id', 'desc')->value('id');
            $prevDataArray = $this->fetchPreviousYearSaleData();
            
            
            if ($detailsArray['ref_id'] != NULL) {
                for ($i=0; $i < count($detailsArray['ref_id']); $i++) { 
                    $total = (float)$detailsArray['bulkArr'][$i] + (float)$detailsArray['packetArr'][$i] + (float)$detailsArray['teaBagArr'][$i] + (float)$detailsArray['instantArr'][$i] + (float)$detailsArray['greenArr'][$i];
                    
                    $totStatus = 'NO';
                    if (count($prevDataArray) > 0) {
                        if ($total > $prevDataArray[$i]->total) {
                            $totStatus = 1;
                        }elseif ($total < $prevDataArray[$i]->total) {
                            $totStatus = 0;
                        }
                    }                  

                    $result = major_importers_details::create([
                        'country_id' => $detailsArray['ref_id'][$i],
                        'importers_main_id' => $latest_id,
                        'bulk_tea' => ($detailsArray['bulkArr'][$i] != NULL) ? floatval(preg_replace('/[^\d.]/', '',$detailsArray['bulkArr'][$i])) : NULL,
                        'packeted_tea' => ($detailsArray['packetArr'][$i] != NULL) ? floatval(preg_replace('/[^\d.]/', '',$detailsArray['packetArr'][$i])) : NULL,
                        'tea_bags'=> ($detailsArray['teaBagArr'][$i] != NULL) ? floatval(preg_replace('/[^\d.]/', '',$detailsArray['teaBagArr'][$i])) : NULL,
                        'instant_tea'=> ($detailsArray['instantArr'][$i] != NULL) ? floatval(preg_replace('/[^\d.]/', '',$detailsArray['instantArr'][$i])) : NULL,
                        'green_tea'=> ($detailsArray['greenArr'][$i] != NULL) ? floatval(preg_replace('/[^\d.]/', '',$detailsArray['greenArr'][$i])) : NULL,
                        'total'=>$total,
                        'total_status'=>$totStatus
                    ]);
                }          
            } 
        }

        if ($result) {
            $message = 'Major Importers added successfully!';
            $value = 1;        
            
        } else {
            $message = 'Major Importers are not added!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );        
     
    }//createMajorImporters



    public function updateMajorImporters($detailsArray){
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;        
        
        $main = major_importers_main::select('*')
                            ->where('id', '=', $detailsArray['main_id'])
                            ->where('sales_code', '=', $this->session_sale_code)
                            ->first();
      
        $main->source = $detailsArray['source'];

        $res = $main->save();

        if ($res) {

            $details = major_importers_details::select('*')
                            ->where('importers_main_id', '=', $detailsArray['main_id'])
                            ->get();

            foreach ($details as $key => $value) {
                $res = $value->delete(); 
            }

            // $totalCalculationsArray = array(
            //                         '1'=>$detailsArray['bulkArr'],
            //                         '2'=>$detailsArray['packetArr'],
            //                         '3'=>$detailsArray['teaBagArr'],
            //                         '4'=>$detailsArray['instantArr'],
            //                         '5'=>$detailsArray['greenArr'],
            //                         );
           
            $prevDataArray = $this->fetchPreviousYearSaleData();
            
            if ($detailsArray['ref_id'] != NULL) {
                for ($i=0; $i < count($detailsArray['ref_id']); $i++) { 
                    
                    $total = (float)$detailsArray['bulkArr'][$i] + (float)$detailsArray['packetArr'][$i] + (float)$detailsArray['teaBagArr'][$i] + (float)$detailsArray['instantArr'][$i] + (float)$detailsArray['greenArr'][$i];

                    $totStatus = 'NO';
                    if (count($prevDataArray) > 0) {
                        if ($total > $prevDataArray[$i]->total) {
                            $totStatus = 1;
                        }elseif ($total < $prevDataArray[$i]->total) {
                            $totStatus = 0;
                        }
                    }
                    
                    $result = major_importers_details::create([
                        'importers_main_id'=>$detailsArray['main_id'],
                        'country_id' => $detailsArray['ref_id'][$i],
                        'bulk_tea' => ($detailsArray['bulkArr'][$i] != NULL) ? floatval(preg_replace('/[^\d.]/', '',$detailsArray['bulkArr'][$i])) : NULL,
                        'packeted_tea' => ($detailsArray['packetArr'][$i] != NULL) ? floatval(preg_replace('/[^\d.]/', '',$detailsArray['packetArr'][$i])) : NULL,
                        'tea_bags'=> ($detailsArray['teaBagArr'][$i] != NULL) ? floatval(preg_replace('/[^\d.]/', '',$detailsArray['teaBagArr'][$i])) : NULL,
                        'instant_tea'=> ($detailsArray['instantArr'][$i] != NULL) ? floatval(preg_replace('/[^\d.]/', '',$detailsArray['instantArr'][$i])) : NULL,
                        'green_tea'=> ($detailsArray['greenArr'][$i] != NULL) ? floatval(preg_replace('/[^\d.]/', '',$detailsArray['greenArr'][$i])) : NULL,
                        'total'=>$total,
                        'total_status'=>$totStatus
                    ]);
                }          
            } 
        }

        if ($result) {
            $message = 'Major Importers updated successfully!';
            $value = 1;        
            
        } else {
            $message = 'Major Importers are not updated!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );        
    }//updateMajorImporters


    public function manipulateMajorImporters(Request $request){
        
        $status = array();

        $bulkArr = $request->bulk;
        $packetArr = $request->packet;
        $teaBagArr = $request->teabags;
        $instantArr = $request->instant;
        $greenArr = $request->green;
        $ref_id = $request->ref_id;

        $availability = $this->fetchDetailsBySalesCode(new major_importers_main(), 'sales_code', $this->session_sale_code);
        $detailArray = array('ref_id'=>$ref_id,'bulkArr'=>$bulkArr,'packetArr'=>$packetArr,'teaBagArr'=>$teaBagArr,'instantArr'=>$instantArr,'greenArr'=>$greenArr,'source'=>$request->source,'main_id'=>$request->main_id);

        if ($availability == NULL) {
            $status = $this->createMajorImporters($detailArray);
        } else {
            $status = $this->updateMajorImporters($detailArray);
        }
        
        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);
    }
}
