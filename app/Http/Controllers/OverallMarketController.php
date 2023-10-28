<?php

namespace App\Http\Controllers;

use App\Http\Traits\DBOperationsTrait;
use App\Models\overall_detail_values;
use App\Models\overall_market;
use App\Models\reference_overall_elevations;
use App\Models\reference_overall_market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OverallMarketController extends Controller
{
    use DBOperationsTrait;

    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');  
            
            return $next($request);
        });
    }

    //------------------------------------ Overall market data related functions ( first section of the view page )--------------------------------------
    public function fetchOverall(){
        $overalMarketDetails = DB::table('overall_market')
                        ->leftjoin('reference_overall_market', 'reference_overall_market.id', '=', 'overall_market.reference_overall_market_id')
                        ->where('overall_market.sales_code','=',$this->session_sale_code)
                        ->select('reference_overall_market.name AS refName','reference_overall_market.id AS refID','overall_market.*')
                        ->get();

        return $overalMarketDetails;
    }//fetchOverall

    public function fetchOverallMarket(){
        // Overall data
        $fetchReferences = $this->fetchData(new reference_overall_market());
        $fetchOverallMarketDetails = $this->fetchOverall();


        // Overall market details data
        $overallDetailValues = $this->fetchOverallDetailValues();
        
        return view('/auction-Highlights/overallMarket',['references'=>$fetchReferences,'fetchOverallMarketDetails'=>$fetchOverallMarketDetails,'overallElevationRefs'=>$overallDetailValues['overallElevationRefs'],'sale_code'=>$this->session_sale_code]);
                
    }//fetchOverallMarket


    public function createOverallMarket($overall_markrt_qty, $overall_demand){
        
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;

        $overall = new overall_market();

        $fetchReferences = $this->fetchData(new reference_overall_market());
        
        foreach ($fetchReferences as $key => $ref) {            

            $ov_qty = NULL;
            if ($overall_markrt_qty[$key] != NULL) {
                $ov_qty = floatval(preg_replace('/[^\d.]/', '', $overall_markrt_qty[$key]));
            }

            $result = overall_market::create([
                'sales_code' => $this->session_sale_code,
                'reference_overall_market_id' => $ref->id,
                'quantity_m_kgs' => $ov_qty,
                'demand' => $overall_demand[$key],
            ]);
        }

        if ($result) {
            $message = 'Overall Market added successfully!';
            $value = 1;
            
            $redirect = '/overall-market';
        } else {
            $message = 'Overall Market added successfully!';
        }
        
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }//createOverallMarket

    public function updateOverallMarket($overall_markrt_qty, $overall_demand){
        
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;
        
        $fetchReferences = $this->fetchData(new reference_overall_market());

        foreach ($fetchReferences as $key => $ref) {
            $overall = overall_market::select('id','quantity_m_kgs','demand')
                        ->where('sales_code', '=',$this->session_sale_code)
                        ->where('reference_overall_market_id', '=', $ref->id)
                        ->first();
            $ov_qty = NULL;
            
            if ($overall_markrt_qty[$key] != NULL) {
                $ov_qty = floatval(preg_replace('/[^\d.]/', '', $overall_markrt_qty[$key]));
            }

            $overall->quantity_m_kgs = $ov_qty;
            $overall->demand = $overall_demand[$key];
            $result = $overall->save();
            
        }
        
        if ($result) {
            $message = 'Overall Market updated successfully!';
            $value = 1;
            
            $redirect = '/overall-market';
        } else {
            $message = 'Overall Market updated successfully!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }//updateOverallMarket
    
    public function manipulateOverall(Request $request) {
        $filedName = 'sale_code';
        $status = array();

        $availability = $this->fetchOverall();
        
        $overall_markrt_qty = $request->overall_markrt_qty;
        $overall_demand = $request->overall_demand;

        if (count($availability) == '0') {
            $status = $this->createOverallMarket($overall_markrt_qty, $overall_demand);
        } else {
            $status = $this->updateOverallMarket($overall_markrt_qty, $overall_demand);
        }
        
        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);
    }//manipulateOverall




    // ------------------------------------ Overall Market details related functions ( Second section of the view page ) -----------------------------------
   
    public function fetchOverallDetailValues(){
        $overallElevationRefs = $this->fetchDataByOrder(new reference_overall_elevations(),'order','asc');
        $fetchOverallDetails = DB::table('overall_detail_values')
                                                ->leftjoin('reference_overall_elevations','reference_overall_elevations.code','=','overall_detail_values.reference_elevation')
                                                ->where('overall_detail_values.sales_code','=',$this->session_sale_code)
                                                ->select('overall_detail_values.*','reference_overall_elevations.order','reference_overall_elevations.name','overall_detail_values.reference_elevation','reference_overall_elevations.level','reference_overall_elevations.parent_category','reference_overall_elevations.column_includes','overall_detail_values.overall_detail_values','overall_detail_values.overall_status_values')
                                                ->get();
        $references = array();

        if (count($fetchOverallDetails) > 0) {
            
            foreach ($fetchOverallDetails as $key => $singleDetail) {
                // print_r($singleDetail);
                // print_r('<br><br>');
                $class = 'level3-overall-names';
                $columns = array();
                $statusArr = array();

                if (($singleDetail->level == 1) & ($singleDetail->column_includes == 1)) {
                    $class = 'level1-overall-names';
                    $columns = json_decode($singleDetail->overall_detail_values);
                } elseif (($singleDetail->level == 1) & ($singleDetail->column_includes == 0)) {
                    $class = 'level1-overall-names';
                } elseif (($singleDetail->level == 2) & ($singleDetail->column_includes == 1)) {
                    $class = 'level2-overall-names';
                    $columns = json_decode($singleDetail->overall_detail_values);
                }elseif (($singleDetail->level == 2) & ($singleDetail->column_includes == 0)) {
                    $class = 'level2-overall-names';
                }else{       
                    $columns = json_decode($singleDetail->overall_detail_values);                        
                    $statusArr = json_decode($singleDetail->overall_status_values);   
                }

                array_push($references,array(
                    'name'=>$singleDetail->name,
                    'class'=>$class,
                    'level'=>$singleDetail->level,
                    'code'=>$singleDetail->reference_elevation,
                    'order'=>$singleDetail->order,
                    'column_includes'=>$singleDetail->column_includes,
                    'columns'=>$columns,
                    'status'=>$statusArr
                ));
            }
        } else {
            
            foreach ($overallElevationRefs as $key => $singleRef) {
                $class = 'level3-overall-names';
                $columns = array();
                $statusArr = array();
                $parentColumns = array();                     
    
                if (($singleRef->level == 1) & ($singleRef['column_includes'] == 1)) {
                    $class = 'level1-overall-names';
                    $columns = json_decode($singleRef->columns);
                } elseif (($singleRef->level == 1) & ($singleRef['column_includes'] == 0)) {
                    $class = 'level1-overall-names';
                } elseif (($singleRef->level == 2) & ($singleRef['column_includes'] == 1)) {
                    $class = 'level2-overall-names';
                    $columns = json_decode($singleRef->columns);
                }elseif (($singleRef->level == 2) & ($singleRef['column_includes'] == 0)) {
                    $class = 'level2-overall-names';
                }else{
                    $parent = $singleRef->parent_category;
                    $parentColumns = DB::table('reference_overall_elevations')
                            ->where('id','=',$parent)
                            ->select('columns')
                            ->first();
                    
                    $decolumns = json_decode($parentColumns->columns);    
                        $count = count($decolumns);      
                        for ($i=0; $i < $count; $i++) { 
                            $columns[$i] = '';
                            $statusArr[$i] = 'NO';
                        }
                }
                
                array_push($references,array(
                    'name'=>$singleRef->name,
                    'class'=>$class,
                    'level'=>$singleRef->level,
                    'code'=>$singleRef->code,
                    'order'=>$singleRef->order,
                    'column_includes'=>$singleRef->column_includes,
                    'columns'=>$columns,
                    'status'=>$statusArr
                ));
                
            }
        }        

        return array('overallElevationRefs'=>$references);        
        // view('auction-Highlights/overallMarket',['overallElevationRefs'=>$overallElevationRefs]);
    }//fetchOverallDetailValues


    public function createOverallDetail($detailsArray){
        $message = '';
        $value = 0;
        $redirect = '';

        $res = overall_detail_values::insert($detailsArray['finalArray']);        

        if ($res) {
            $message = 'Overall Detail Values added successfully!';
            $value = 1;        
            
        } else {
            $message = 'Overall Detail Values are not added!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );        
    }//createOverallDetail


    public function updateOverallDetail($detailsArray){
        $message = '';
        $value = 0;
        $redirect = '';
        $res = 0;
        $idArr = array();

        $ids = overall_detail_values::select('id')
                            ->where('sales_code', '=',$this->session_sale_code)
                            ->get();  

        foreach ($ids as $key => $value) {
            $idArr[] = $value['id'];
        }
        
        $delete = overall_detail_values::whereIn('id', $idArr)->delete();
        
        $res = overall_detail_values::insert($detailsArray['finalArray']);

        if ($res) {
            $message = 'Overall Detail Values updated successfully!';
            $value = 1;        
            
        } else {
            $message = 'Overall Detail Values are not updated!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );  
    }//updateOverallDetail


    public function manipulateOverallDetail(Request $request){
        $status = array();      
        $finalArray = array();
        $references = $this->fetchData(new reference_overall_elevations()); 
                
        $elevationNamesArray = $request->elevation_name;    
        
        foreach ($references as $mainKey => $singleElevation) {
                        
            $columns = array();
            $statusArr = array();
            $statusArr[$mainKey] = array();
            
            if (($singleElevation->level == 1) & ($singleElevation->column_includes == 1)) {   
                $columns[$mainKey] = json_decode($singleElevation->columns);
            } elseif (($singleElevation->level == 1) & ($singleElevation->column_includes == 0)) {
                $columns[$mainKey] = array();
            } elseif (($singleElevation->level == 2) & ($singleElevation->column_includes == 1)) {                
                $columns[$mainKey] = json_decode($singleElevation->columns);             
            }elseif (($singleElevation->level == 2) & ($singleElevation->column_includes == 0)) {
                $columns[$mainKey] = array();
            }else{               
                $parent = $singleElevation->parent_category;
                $parentColumns = DB::table('reference_overall_elevations')
                            ->where('id','=',$parent)
                            ->select('columns')
                            ->first();
                $decolumns = json_decode($parentColumns->columns);    
                
                // print_r($decolumns);      
                for ($i=0; $i < count($decolumns); $i++) {      

                    $state = 'state_'.$mainKey.$i;
                    $value = $request->$state;  
                    $statusArr[$mainKey][$i] = $value;
                }
                $ov_value = 'overall_value_'.$mainKey;
                $ovr_value = $request->$ov_value;      
                $columns[$mainKey] = $ovr_value;                             
            }       

            $type = 'TITLE';
            if ($singleElevation->level == 3) {
                $type = 'VALUES';
            }   
            $encodedColumnSet = NULL;
            $encodedStatusSet = NULL;
            if ($columns[$mainKey] != NULL) {
                $encodedColumnSet = json_encode($columns[$mainKey]);
            }
            if ($statusArr[$mainKey] != NULL) {
                $encodedStatusSet = json_encode($statusArr[$mainKey]);
            }
            array_push($finalArray, array(
                'sales_code'=>$this->session_sale_code,
                'reference_elevation'=>$elevationNamesArray[$mainKey],
                'overall_detail_values'=>$encodedColumnSet,
                'overall_status_values'=>$encodedStatusSet,
                'type'=> $type
            ));        
        }         

        $availability = $this->fetchDetailsBySalesCode(new overall_detail_values(), 'sales_code', $this->session_sale_code);
        $detailArray = array('finalArray'=>$finalArray);

        if ($availability == NULL) {
            $status = $this->createOverallDetail($detailArray);
        } else {
            $status = $this->updateOverallDetail($detailArray);
        }

        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);        

    }//manipulateOverallDetail

}

