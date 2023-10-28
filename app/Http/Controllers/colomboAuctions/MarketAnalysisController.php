<?php

namespace App\Http\Controllers\colomboAuctions;
use App\Http\Controllers\Controller;

use App\Http\Traits\DBOperationsTrait;
use App\Models\market_analysis_details;
use App\Models\market_analysis_main;
use App\Models\market_analysis_main_areas;
use App\Models\market_descriptions;
use App\Models\reference_market_rows_columns;
use App\Models\sales_list;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class MarketAnalysisController extends Controller
{

    use DBOperationsTrait;
    private $session_sale_code;
    private $market_analysis_elevation_id;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');  
            $this->market_analysis_elevation_id = session()->get('market_analysis_elevation_id');
            
            return $next($request);
        });
    }

    // To form the array with market analysis detail data
    public function fetchMarketAnalysisDetails($areaId){
        $references = reference_market_rows_columns::find($areaId);

        $marketDescriptions = market_descriptions::select('*')
                                            ->where('sales_code', '=',$this->session_sale_code)
                                            ->where('elevation_id', '=', $areaId)
                                            ->get(); 
        

        $formedTextDate = $this->formDateInShortTextFormat(new sales_list(), 'sales_Code', $this->session_sale_code);

        $all_references = array();
        $formedArray = array();        

        $all_references['id'] = $areaId;
        $all_references['code'] = $references->code;
        $all_references['description_details'] = json_decode($references->description_tea_grades);
        $all_references['table_columns'] = json_decode($references->table_columns);
        $all_references['table_rows'] = json_decode($references->table_rows);

        $detailsArray = market_analysis_details::select('*')
                                                ->where('sales_code', '=',$this->session_sale_code)
                                                ->where('elevation_id', '=', $areaId)
                                                ->get();        
        
        if (count($detailsArray) > 0) {

            foreach ($detailsArray as $key => $value) {
                $data_values = json_decode($value['values']);
                $status_values = json_decode($value['status_values']);
                
                $data = array();
                $statuses = array();

                for ($i=0 ; $i < count($data_values); $i++) { 
                    array_push($data,$data_values[$i]);
                }

                if ($status_values != null) {
                    for ($i=0 ; $i < count($status_values); $i++) { 
                        array_push($statuses, $status_values[$i]);
                    }
                }           

                array_push($formedArray,array(
                    'name'=>$value['name'],
                    'type'=>$value['type'],
                    'values' => $data,
                    'status' => $statuses
                ));         
            }          
        }else{

            $data = array();
            $statuses = array();
            $formedDates = array();
            
            for ($i=0; $i < count($all_references['table_columns']); $i++) { 
                array_push($data,'');
                array_push($statuses,'NO');
                array_push($formedDates,$formedTextDate);
            }

            $formedArray[0] = ['name'=> "QUOTATIONS LKR",'type'=>"TITLE",'values'=>$all_references['table_columns'],'status'=> array()];
            $formedArray[1] = ['name'=> "SALE DATE",'type'=>"TITLE",'values'=>$formedDates,'status'=>array()];

            foreach ($all_references['table_rows'] as $key => $singleRow) {
                array_push($formedArray,array(
                    'name'=>$singleRow,
                    'type'=>'VALUES',
                    'values'=>$data,
                    'status'=>$statuses
                )); 
            }  
        }

        return array('all_references'=>$all_references,'marketDescriptions'=>$marketDescriptions,'detailsArray'=>$formedArray);
    }//fetchMarketAnalysisDetails


    // To fetch and display the market analysis detils into the frontend
    // The code from the GET url is taken and retrieves data
    public function fetchMarketAnalysis($code = null){
        
        $marketRefDetails = reference_market_rows_columns::select('*')
                            ->where('code', '=',$code)
                            ->first();  
        
        $previous_query = reference_market_rows_columns::select('code')
                            ->where('id', '<',$marketRefDetails->id)
                            ->orderBy('id','desc')
                            ->first();

        $next_query = reference_market_rows_columns::select('code')
                            ->where('id', '>',$marketRefDetails->id)
                            ->orderBy('id','asc')
                            ->first(); 
                            
        $previous = '/crop-and-weather';      
        $next = '/top-prices';  
                            
        if ($previous_query != NULL) {
            $previous = $previous_query->code;
        }   
        
        if ($next_query != NULL) {
            $next = $next_query->code;
        }

        $references = $this->fetchMarketAnalysisDetails($marketRefDetails->id);
        
        return view('colombo-auctions/marketAnalysis',['descriptionReferences'=>$references['all_references'],'marketDescriptions'=>$references['marketDescriptions'],'detailsArray'=>$references['detailsArray'],'areaId'=>$marketRefDetails->id,'code'=>$code,'name'=>$marketRefDetails->elevation_name,'previous'=>$previous,'next'=>$next]);
    }//fetchMarketAnalysis


    // To add the market analysis details (table data)
    public function createMarketAnalysis($detailsArray){
        $message = '';
        $value = 0;
        $redirect = '';

        $res = market_analysis_details::insert($detailsArray['finalArray']);        

        if ($res) {
            $message = $detailsArray['name'].' details added successfully!';
            $value = 1;        
            
        } else {
            $message = $detailsArray['name'].' details are not added!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );        
    }//createMarketAnalysis


    // To update the market analysis details (table data)
    public function updateMarketAnalysis($detailsArray){
        
        $message = '';
        $value = 0;
        $redirect = '';
        $res = 0;
        $idArr = array();

        $ids = market_analysis_details::select('id')
                            ->where('sales_code', '=',$this->session_sale_code)
                            ->where('elevation_id', '=', $detailsArray['areaId'])
                            ->get();  

        foreach ($ids as $key => $value) {
            $idArr[] = $value['id'];
        }
        
        $delete = market_analysis_details::whereIn('id', $idArr)->delete();
        
        $res = market_analysis_details::insert($detailsArray['finalArray']);

        if ($res) {
            $message = $detailsArray['name'].' details updated successfully!';
            $value = 1;        
            
        } else {
            $message = $detailsArray['name'].'Market details are not updated!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );              
    }//updateMarketAnalysis


    // to check the availability of market details (table data)
    public function manipulateMarket(Request $request){
        $status = array();      
        $finalArray = array();
        $references = reference_market_rows_columns::find($request->areaId);   
        $countColumns = count(json_decode($references->table_columns));
        $countRows = count(json_decode($references->table_rows))+2;

        $chunckedDetails = array_chunk($request->details,$countColumns);
        $namesArray = $request->name;

        for ($i = 0; $i < $countRows; $i++ ) {            
            $statusArray[$i] = array();
            for ($j=0; $j < $countColumns; $j++) {                         
                $state = 'state_'.$i.$j;
                $value = $request->$state;               
                array_push($statusArray[$i],$value);
            }

            $finalStatusArr = json_encode($statusArray[$i]);
            $type = 'VALUES';
            if (($i == 0) | ($i == 1)) {
                $finalStatusArr = 'NULL';
                $type = 'TITLE';
            }

            array_push($finalArray, array(
                'sales_code'=>$this->session_sale_code,
                'elevation_id'=>$request->areaId,
                'name'=>$namesArray[$i],
                'values'=>json_encode($chunckedDetails[$i]),
                'status_values'=>$finalStatusArr,
                'type'=> $type
            ));
        }                

        $availability = $this->fetchDetailsBySalesCode(new market_analysis_details(), 'sales_code', $this->session_sale_code);
        $detailArray = array('finalArray'=>$finalArray,'areaId'=>$request->areaId,'name'=>$references->elevation_name);

        if ($availability == NULL) {
            $status = $this->createMarketAnalysis($detailArray);
        } else {
            $status = $this->updateMarketAnalysis($detailArray);
        }
        
        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);

    }//manipulateMarket


    // To create market descriptions
    public function createMarketDescriptions($detailsArray){
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;
        
        // $details = new market_descriptions();
        
        if ($detailsArray['refgradesArr'] != NULL) {
            for ($i=0; $i < count($detailsArray['refgradesArr']); $i++) { 
                
                $result = market_descriptions::create([
                    'elevation_id' => $detailsArray['elevation_id'],
                    'sales_code' => $this->session_sale_code,
                    'tea_grade' => $detailsArray['refgradesArr'][$i],
                    'description' => $detailsArray['descArr'][$i],
                ]);
            }          
        } 
        

        if ($result) {
            $message = 'Market Analysis descriptions added successfully!';
            $value = 1;        
            
        } else {
            $message = 'Market Analysis descriptions are not added!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );  
    }//createMarketDescriptions


    // To update market descriptions
    public function updateMarketDescriptions($detailsArray){
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;   

        $details = market_descriptions::select('*')
                        ->where('elevation_id', '=', $detailsArray['elevation_id'])
                        ->where('sales_code', '=', $this->session_sale_code)
                        ->get();

        foreach ($details as $key => $value) {
            $res = $value->delete(); 
        }
       
        if ($detailsArray['refgradesArr'] != NULL) {
            for ($i=0; $i < count($detailsArray['refgradesArr']); $i++) { 
                
                $result = market_descriptions::create([
                    'elevation_id'=>$detailsArray['elevation_id'],
                    'sales_code'=>$this->session_sale_code,
                    'tea_grade' => $detailsArray['refgradesArr'][$i],
                    'description' => $detailsArray['descArr'][$i],
                ]);
            }          
        }         

        if ($result) {
            $message = 'Market Analysis descriptions updated successfully!';
            $value = 1;        
            
        } else {
            $message = 'Market Analysis descriptions are not updated!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );        

    }//updateMarketDescriptions


    // To check the availability of market descriptions
    public function manipulateMarketDescriptions(Request $request){
        $status = array();

        $refgradesArr = $request->ref_tea_grade;
        $descArr = $request->desc;

        $availability = $this->fetchDataSetBySaleCode(new market_descriptions(), 'sales_code', $this->session_sale_code);
        $detailArray = array('refgradesArr'=>$refgradesArr,'descArr'=>$descArr,'elevation_id'=>$request->elevation_id);

        if (count($availability) > 0) {
            $status = $this->updateMarketDescriptions($detailArray);
        } else {
            $status = $this->createMarketDescriptions($detailArray);
        }
        
        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=>$status['redirect']
        ),200);
    }//manipulateMarketDescriptions

}
