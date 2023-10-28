<?php
namespace App\Http\Traits;

use App\Models\additional_pages;
use App\Models\auction_descriptions;
use App\Models\reference_overall_elevations;
use App\Models\reference_overall_market;
use App\Models\sales_list;
use Illuminate\Support\Facades\DB;

trait AuctionHighlightsTrait{

    use ReportPreviousData,DBOperationsTrait;

    public function getOverallValues($currentSaleCode){
        $overalMarketValues = DB::table('overall_market')
                            ->leftjoin('reference_overall_market', 'reference_overall_market.id', '=', 'overall_market.reference_overall_market_id')
                            ->where('overall_market.sales_code','=',$currentSaleCode)
                            ->select('reference_overall_market.name AS refName','reference_overall_market.id AS refID','overall_market.*')
                            ->get();

        return $overalMarketValues;
    }


    
    public function fetchOverallDetailValues($currentSaleCode){
        $overallElevationRefs = $this->fetchDataByOrder(new reference_overall_elevations(),'order','asc');
        $fetchOverallDetails = DB::table('overall_detail_values')
                                                ->leftjoin('reference_overall_elevations','reference_overall_elevations.code','=','overall_detail_values.reference_elevation')
                                                ->where('overall_detail_values.sales_code','=',$currentSaleCode)
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


    public function fetchOverallValues($currentSaleCode){
        $fetchReferences = $this->fetchData(new reference_overall_market());
        $fetchOverallValues = $this->getOverallValues($currentSaleCode);

        // Overall market details data
        $overallDetailValues = $this->fetchOverallDetailValues($currentSaleCode);

        return array('references'=>$fetchReferences,'values'=>$fetchOverallValues,'detailValues'=>$overallDetailValues);
    }//end fetchOverallValues


    public function fetchAuctionDescriptions($currentSaleCode){
        $auctionDescriptions = $this->fetchDataSetBySaleCode(new auction_descriptions(), 'sale_code', $currentSaleCode);

        return array('descriptions'=>$auctionDescriptions);
    }// end fetchAuctionDescriptions



    public function fetchAddNewPageDetails($currentSaleCode){
        $detailsArray = array();
        $details = additional_pages::select('*')
                            ->where('page_type', '=','AUCTION_HIGHLIGHTS')
                            ->where('sale_code', '=',$currentSaleCode)
                            ->first();  

        if ($details != NULL) {
            $detailsArray['type'] = 'AUCTION_HIGHLIGHTS';
            $detailsArray['title'] = $details->title;
            $detailsArray['content'] = $details->content;
        } else {
            $detailsArray['type'] = 'AUCTION_HIGHLIGHTS';
            $detailsArray['title'] = '';
            $detailsArray['content'] = '';
        }

        return $detailsArray;
        
    }//end fetchAddNewPageDetails


    public function fetchCataloguesQuantities($currentSaleCode){
        
        $awaiting_sale_code_1 = $this->getAwaitingSaleNumber($currentSaleCode,1);

        $awaiting_sale_code_2 = $this->getAwaitingSaleNumber($currentSaleCode,2);

        $awaitingdate_1 = $this->formDateInShortTextFormat(new sales_list(),'sales_code',$awaiting_sale_code_1);

        $awaitingdate_2 = $this->formDateInShortTextFormat(new sales_list(),'sales_code',$awaiting_sale_code_2);

        $dataset1 = DB::table('awaiting_lots_qty_summary')
                    ->where('sales_code','=',$awaiting_sale_code_1)
                    ->first();


        $dataset2 = DB::table('awaiting_lots_qty_summary')
                    ->where('sales_code','=',$awaiting_sale_code_2)
                    ->first();
                     
        $awating_lots_1 = 0;
        $awating_lots_2 = 0;
        $awating_qty_1 = 0;            
        $awating_qty_2 = 0; 

        if ($dataset1 != NULL) {
            if ($dataset1->lots != NULL) {
                $awating_lots_1 = number_format($dataset1->lots,2);
                $awating_qty_1 = number_format($dataset1->quantity,2);  
            }
        }

        if ($dataset2 != NULL) {
            if ($dataset2->lots != NULL) {
                $awating_lots_2 = number_format($dataset2->lots,2);
                $awating_qty_2 = number_format($dataset2->quantity,2);  
            }
        }

        return array(
            'awaiting1_lots'=>$awating_lots_1,
            'awaiting1_quantity'=>$awating_qty_1,
            'awaiting_sale_code_1'=>$awaiting_sale_code_1,
            'awaiting_sale_1_dates'=>$awaitingdate_1,
            'awaiting_sale_2_dates'=>$awaitingdate_2,
            'awaiting2_lots'=>$awating_lots_2,
            'awaiting2_quantity'=>$awating_qty_2,
            'awaiting_sale_code_2'=>$awaiting_sale_code_2
        );

    }// end fetchCataloguesQuantities
}