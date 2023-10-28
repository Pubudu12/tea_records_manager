<?php

namespace App\Http\Controllers;

use App\Http\Traits\DBOperationsTrait;
use App\Models\reference_top_prices;
use App\Models\topPrices;
use App\Models\top_prices_detail;
use App\Models\top_prices_regions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopPriceController extends Controller
{
    use DBOperationsTrait;

    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('SelectedSaleCode');

            return $next($request);
        });
    }

    public function getTopPrices(){

        $fetchMainRegions = DB::table('reference_top_prices')
                            ->where('level','=',1)
                            ->get();
        
        $regionsArr = array();   
        $fetchedRegions = array();     

        foreach ($fetchMainRegions as $key => $mainRegion) {
            $tempCode = $mainRegion->code;
            $regionsArr[$tempCode]['name'] = $mainRegion->name;
            $regionsArr[$tempCode]['main_code'] = $mainRegion->code;

            $fetchTopPriceDetails = DB::table('top_prices')  
                                    ->where('sale_code','=',$this->session_sale_code)   
                                    ->where('reference_code','=',$mainRegion->code)                       
                                    ->select('*')
                                    // ->orderBy('top_prices.created', 'DESC')
                                    ->get();

            // DB::table('reference_top_prices')
            //                     ->leftjoin('top_prices','top_prices.mark_code','=','reference_top_prices.code')
            //                     ->where('top_prices.sale_code','=',$this->session_sale_code)
            //                     ->where('reference_top_prices.parent_code','=',$mainRegion->code)
            //                     ->select('reference_top_prices.id', 'reference_top_prices.code', 'reference_top_prices.name', 'reference_top_prices.parent_code', 'reference_top_prices.level',
            //                         'top_prices.varities','top_prices.is_forbes', 'top_prices.asterisk', 'top_prices.value')
            //                     ->get();
                                

            if (count($fetchTopPriceDetails) > 0) {
                foreach ($fetchTopPriceDetails as $key => $singleTopPriceDetail) {

                    // $tempParentCode = $singleTopPriceDetail->parent_code;

                    $tempChildArray = array(
                        'name' => $singleTopPriceDetail->mark_name,
                        'code' => $tempCode,
                        'value' => $singleTopPriceDetail->value,
                        'varities' => $singleTopPriceDetail->varities,
                        'asterisk' => $singleTopPriceDetail->asterisk,
                        'is_forbes' => $singleTopPriceDetail->is_forbes,
                        'subRegionSet'=>NULL
                    );
    
                    if(isset($regionsArr[$mainRegion->code]['marks'])){
                        // If array is already created
                        array_push($regionsArr[$mainRegion->code]['marks'], $tempChildArray);
                    }else{
                        // Create Array and push
                        $regionsArr[$mainRegion->code]['marks'] = array($tempChildArray);
                    } // Marks
                }
            } else {
                $fetchSubRegions = DB::table('reference_top_prices')
                                    ->where('parent_code','=',$mainRegion->code)
                                    ->get();

                    $tempChildArray = array(
                        'name' => '',
                        'code' => '',
                        'value' => '',
                        'varities' => '',
                        'asterisk' => '',
                        'is_forbes' => '',
                        'subRegionSet' =>$fetchSubRegions
                    );
    
                    $regionsArr[$mainRegion->code]['marks'] = array($tempChildArray);
                    
                // }
            }                                
        }

        $fetchedRegions = DB::table('reference_top_prices')
                            ->leftjoin('top_prices', function ($join) {
                                $join->on('top_prices.mark_code','=','reference_top_prices.code')->where('top_prices.sale_code','=', $this->session_sale_code);
                            })
                            ->select('reference_top_prices.id', 'reference_top_prices.code', 'reference_top_prices.name', 'reference_top_prices.parent_code', 'reference_top_prices.level',
                                    'top_prices.varities','top_prices.is_forbes', 'top_prices.asterisk', 'top_prices.value')
                            // ->orderBy('top_prices.created', 'DESC')
                            ->get();    

        

        // foreach($fetchedRegions AS $key => $singleFetchedRegion){

        //     // if (!is_null($singleFetchedRegion->value)) {                
        //     //     print_r('NOT NULL<br>');
        //     // } else {
        //     //     print_r('<br>--- E-NULL---<br>');
        //     // }     

        //     // print_r('<br>-----<br>');
        //     // print_r($singleFetchedRegion->code);

        //     $tempCode = $singleFetchedRegion->code;

        //     if($singleFetchedRegion->level == 1){
        //         $regionsArr[$tempCode]['name'] = $singleFetchedRegion->name;
        //     }else{

        //         $tempParentCode = $singleFetchedRegion->parent_code;

        //         $tempChildValue = $singleFetchedRegion->value;
        //         if(is_null($singleFetchedRegion->value)){
        //             $tempChildValue = '';
        //         }

        //         $tempChildVarities = $singleFetchedRegion->varities;
        //         if(is_null($singleFetchedRegion->varities)){
        //             $tempChildVarities = '';
        //         }

        //         $tempChildAstrics = $singleFetchedRegion->asterisk;
        //         if(is_null($singleFetchedRegion->asterisk)){
        //             $tempChildAstrics = '';
        //         }

        //         $tempIs_forbes = $singleFetchedRegion->is_forbes;
        //         if(is_null($singleFetchedRegion->is_forbes)){
        //             $tempIs_forbes = '';
        //         }

        //         $tempChildArray = array(
        //             'name' => $singleFetchedRegion->name,
        //             'code' => $tempCode,
        //             'value' => $tempChildValue,
        //             'varities' => $tempChildVarities,
        //             'asterisk' => $tempChildAstrics,
        //             'is_forbes' => $tempIs_forbes,
        //         );

        //         if(isset($regionsArr[$tempParentCode]['marks'])){
        //             // If array is already created
        //             array_push($regionsArr[$tempParentCode]['marks'], $tempChildArray);
        //         }else{
        //             // Create Array and push
        //             $regionsArr[$tempParentCode]['marks'] = array($tempChildArray);
        //         } // Marks
        //     }
        // }
        return view('colombo-auctions/topPrices',['topPricesSets'=> ($regionsArr),'regionSet'=>$fetchedRegions ]);

    }//getTopPrices


    public function createTopPriceDetails($detailsArr){
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;

        $details = new top_prices_detail();

        if ($detailsArr['regionArr'] != NULL) {
            for ($i=0; $i < count($detailsArr['regionArr']); $i++) {
                $status = 0;
                if (isset($detailsArr['statusArr'][$i])) {
                    if ($detailsArr['statusArr'][$i] == 'on') {
                        $status = 1;
                    }
                }
                $result = top_prices_detail::create([
                    'sale_code' => $this->session_sale_code,
                    'top_prices_regions_id' => $detailsArr['regionArr'][$i],
                    'price' => $detailsArr['priceArr'][$i],
                    'status' => 1,
                ]);
            }
        }

        if ($result) {
            $message = 'Top Price Details updated successfully!';
            $value = 1;

        } else {
            $message = 'Top Price Details are not updated!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect
        );
    }//createTopPriceDetails


    public function updateTopPriceDetails($detailArray){
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;

        // $fetchReferences = $this->fetchData(new reference_overall_market());

        $topPriceData = $this->fetchDataSetBySaleCode(new top_prices_detail(), 'sale_code', $this->session_sale_code);

        foreach ($topPriceData as $key => $value) {
            $res = $value->delete();
        }

        if ($detailArray['regionArr'] != NULL) {
            for ($i=0; $i < count($detailArray['regionArr']); $i++) {
                $status = 0;
                if (isset($detailArray['statusArr'][$i])) {
                    if ($detailArray['statusArr'][$i] == 'on') {
                        $status = 1;
                    }
                }
                $result = top_prices_detail::create([
                    'sale_code' => $this->session_sale_code,
                    'top_prices_regions_id' => $detailArray['regionArr'][$i],
                    'price' => $detailArray['priceArr'][$i],
                    'status' => 1,
                ]);
            }
        }

        if ($result) {
            $message = 'Top Price Details updated successfully!';
            $value = 1;
        } else {
            $message = 'Top Price Details is not updated!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect
        );
    }//updateTopPriceDetails


    private function deleteTopPrices($refMarksCode){

        // Sales Code Wise Delete prices
        $saleCode = $this->session_sale_code;

        // $delete = topPricesDB::delete('delete users where name = ?', ['John']);
        $delete = topPrices::where('sale_code', $saleCode);
        $delete->where('reference_code', $refMarksCode);

        $delete->delete();

        if($delete){
            return true;
        }else{
            return false;
        }

    } //deleteTopPrices


    public function postTopPrices(Request $request){

        $status = array(
            'message' => 'Failed to update top prices',
            'result' => 0,
            'redirect' => '',
        );

        $saleCode = $this->session_sale_code;
        $marksArr = $request->mark;
        $reference = $request->parent_code;
        $asteriskArr = $request->asterisk;
        $varitieskArr = $request->varities;
        $is_forbesArr = $request->is_forbes;
        $valueArr = $request->value;

        $status['rawinsert'] = $is_forbesArr;   
        
        // elete Existing Rows of the Report
        $this->deleteTopPrices($reference);

        #Insert Data Array
        $insertDataArray = array();

        // Process Data
        if(count($marksArr) > 0){
            foreach ($marksArr as $key => $singleMarkCode) {

                $singleMarkCode = $singleMarkCode;
                if(strlen($singleMarkCode) < 1){
                    $singleMarkCode = null;
                }
                
                // $reference = NULL;
                // if($referenceArr[$key] != NULL){
                //     // It Should Be NULL
                //     $reference = $referenceArr[$key];
                //     print_r($reference);
                //     print_r('<br><br>');
                // }

                $singleTempValue = NULL;
                if($valueArr[$key] != NULL){
                    // It Should Be NULL
                    $singleTempValue = floatval(preg_replace('/[^\d.-]/', '',$valueArr[$key]));
                }

                $singleTempAsteriesk = $asteriskArr[$key];
                $singleTempVarity = $varitieskArr[$key];

                $singleTempIsForbes = '0';
                if(is_array($is_forbesArr)){
                    if(in_array(($reference.'_'.$key), $is_forbesArr)){
                        $singleTempIsForbes = '1';
                    }
                }                

                // Mark Code
                // if( !is_null($singleMarkCode) &&  ( !is_null($singleTempValue) ) ){

                    array_push($insertDataArray,array(
                        'sale_code'=> $saleCode,
                        'reference_code' => $reference,
                        'mark_name' => $singleMarkCode,
                        'varities' => $singleTempVarity,
                        'is_forbes' => $singleTempIsForbes,
                        'asterisk' => $singleTempAsteriesk,
                        'value' => $singleTempValue
                    ));
                // }
            }
        }

        if(count($insertDataArray) > 0){    
            // Insert Data
            $insert = topPrices::insert($insertDataArray);
            
            if($insert){
                $status['message'] = 'Top prices are updated successfully';
                $status['result'] = 1;
            }
        }

        return json_encode($status, 200);

    } //postTopPrices

    

    public function manipulateTopPrice(Request $request){
        $filedName = 'sale_code';
        $status = array();

        $statusArr = $request->status;
        $regionArr = $request->region_id;
        $priceArr = $request->price;

        $availability = $this->fetchDataSetBySaleCode(new top_prices_detail(), 'sale_code', $this->session_sale_code);
        $detailArray = array('statusArr'=>$statusArr,'regionArr'=>$regionArr,'priceArr'=>$priceArr);

        if (count($availability) == '0') {
            $status = $this->createTopPriceDetails($detailArray);
        } else {
            $status = $this->updateTopPriceDetails($detailArray);
        }

        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect']
         ), 200);
    }//manipulateTopPrice


    // To export all the top price details
    public function exportTopPrices(){             
            
        // Excel file name for download
        $fileName = "top-prices-details on " . date('Y-m-d') . ".xls"; 
        
        // Column names 
        $fields = array('ELEVATION', 'MARK NAME', 'ASTERIC', 'GRADE', '@', 'VALUE');
        $excelData = implode("\t", array_values($fields)) . "\n"; 

        // Display an emprty row
        $fields = array('', '', '', '', '', '');
        $excelData .= implode("\t", array_values($fields)) . "\n"; 
            
        $fetchMainRegions = DB::table('reference_top_prices')
                                ->where('level','=',1)
                                ->get();   

        foreach ($fetchMainRegions as $key => $mainRegion) {

            $mainLineData = array($mainRegion->name, '', '', '', '', '');
            $excelData .= implode("\t", array_values($mainLineData)) . "\n";

            $fetchTopPriceDetails = DB::table('top_prices')  
                                        ->where('sale_code','=',$this->session_sale_code)    
                                        ->where('reference_code','=',$mainRegion->code)                    
                                        ->select('*')
                                        ->get();

            if (count($fetchTopPriceDetails) > 0) {
                // Output each row of the data 
                foreach ($fetchTopPriceDetails as $key => $singleTopPriceDetail) {
                    
                    $lineData = array('', $singleTopPriceDetail->mark_name, $singleTopPriceDetail->asterisk, $singleTopPriceDetail->varities, $singleTopPriceDetail->is_forbes, number_format($singleTopPriceDetail->value,2));
                    
                    $excelData .= implode("\t", array_values($lineData)) . "\n";
                } 
                $emptyFields = array('', '', '', '', '', '');
                $excelData .= implode("\t", array_values($emptyFields)) . "\n";
            }else{ 
                $excelData .= 'No records found...'. "\n"; 

                $emptyFields = array('', '', '', '', '', '');
                $excelData .= implode("\t", array_values($emptyFields)) . "\n";
            } 
        }
        
        // Headers for download
        header("Content-Type: application/vnd.ms-excel"); 
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        
        // Render excel data 
        echo $excelData;           

    }// end exportTopPrices
}
