<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;

trait MarketDashboardTrait{

    use ReportPreviousData;

    public function fetchMarketData($salecode){
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

        // Year changes - same sale number
        $yearBeforePrevYearTotalValues = DB::table('details_of_qualtity_sold')
                                        ->where('sale_code','=' ,$yearBeforePrevSaleCode)
                                        ->select('quantity_m_kgs','avg_price_lkr','avg_price_usd',)
                                        ->first();

        $prevYearSaleTotalValues = DB::table('details_of_qualtity_sold')
                                        ->where('sale_code','=' ,$prevSaleCode)
                                        ->select('quantity_m_kgs','avg_price_lkr','avg_price_usd',)
                                        ->first();

        $currentTotalValues = DB::table('details_of_qualtity_sold')
                                        ->where('sale_code','=' ,$salecode)
                                        ->select('quantity_m_kgs','avg_price_lkr','avg_price_usd',)
                                        ->first();


        // Sale number changes        
        $prevYear = (int)$currentYear - 1;
        $prevSaleCode = $prevYear.'-'.($currentSaleNo - 1);

        $currentLastSale = $currentYear.'-'.($currentSaleNo - 1);
        $yearBeforePrevYear = (int)$prevYear - 1;
        $yearBeforePrevSaleCode = $yearBeforePrevYear.'-'.($currentSaleNo - 1);

        $LastSale_yearBeforePrevYearTotalValues = DB::table('details_of_qualtity_sold')
                                        ->where('sale_code','=' ,$yearBeforePrevSaleCode)
                                        ->select('quantity_m_kgs','avg_price_lkr','avg_price_usd',)
                                        ->first();

        $LastSale_prevYearSaleTotalValues = DB::table('details_of_qualtity_sold')
                                        ->where('sale_code','=' ,$prevSaleCode)
                                        ->select('quantity_m_kgs','avg_price_lkr','avg_price_usd',)
                                        ->first();

        $LastSale_currentTotalValues = DB::table('details_of_qualtity_sold')
                                        ->where('sale_code','=' ,$currentLastSale)
                                        ->select('quantity_m_kgs','avg_price_lkr','avg_price_usd',)
                                        ->first();


        // Sale number changes        
        $prevYear = (int)$currentYear - 2;
        $prevSaleCode = $prevYear.'-'.($currentSaleNo - 2);

        $currentLastSale = $currentYear.'-'.($currentSaleNo - 2);
        $yearBeforePrevYear = (int)$prevYear - 1;
        $yearBeforePrevSaleCode = $yearBeforePrevYear.'-'.($currentSaleNo - 2);

        $prevLastSaleYBPYdata = DB::table('details_of_qualtity_sold')
                                        ->where('sale_code','=' ,$yearBeforePrevSaleCode)
                                        ->select('quantity_m_kgs','avg_price_lkr','avg_price_usd',)
                                        ->first();

        $prevLastSaleprevYdata = DB::table('details_of_qualtity_sold')
                                        ->where('sale_code','=' ,$prevSaleCode)
                                        ->select('quantity_m_kgs','avg_price_lkr','avg_price_usd',)
                                        ->first();

        $prevLastSaleCurrntdata = DB::table('details_of_qualtity_sold')
                                        ->where('sale_code','=' ,$currentLastSale)
                                        ->select('quantity_m_kgs','avg_price_lkr','avg_price_usd',)
                                        ->first();


        return array(
            'yearBeforePrevYearTotalValues'=>$yearBeforePrevYearTotalValues,
            'prevYearSaleTotalValues'=>$prevYearSaleTotalValues,
            'currentTotalValues'=>$currentTotalValues,
            'lastSaleYBPYdata'=>$LastSale_yearBeforePrevYearTotalValues,
            'lastSaleprevYdata'=>$LastSale_prevYearSaleTotalValues,
            'lastSaleCurrntdata'=>$LastSale_currentTotalValues,
            'prevLastSaleYBPYdata'=>$prevLastSaleYBPYdata,
            'prevLastSaleprevYdata'=>$prevLastSaleprevYdata,
            'prevLastSaleCurrntdata'=>$prevLastSaleCurrntdata,
            'currenctSaleNum'=>$currentSaleNo,
            'lastSaleNum'=>($currentSaleNo-1),
            'saleBeforeLastNum'=>($currentSaleNo-2),
        );
    }//fetchPreviousYearSaleData

    private function fetchPreviousYearSaleData($previousSaleCode){

        $prevYearsData = array();



        foreach ($previousSaleCode as $key => $value) {
            $quantity_m_kgs = 0;
            $avg_price_lkr = 0;
            $avg_price_usd = 0;
            
            $data = DB::table('details_of_qualtity_sold')
                        ->where('sale_code','=' ,$value)
                        ->select('quantity_m_kgs','avg_price_lkr','avg_price_usd',)
                        ->first();

            if (isset($data->quantity_m_kgs)) {
                $quantity_m_kgs = $data->quantity_m_kgs;
            }

            if (isset($data->avg_price_lkr)) {
                $avg_price_lkr = $data->avg_price_lkr;
            }

            if (isset($data->avg_price_usd)) {
                $avg_price_usd = $data->avg_price_usd;
            }

            array_push($prevYearsData,array(
                'quantity_m_kgs'=>$quantity_m_kgs,
                'avg_price_lkr'=>$avg_price_lkr,
                'avg_price_usd'=>$avg_price_usd,
            ));       
        }
        // print_r($prevYearsData);
        return $prevYearsData;
    }//fetchPreviousYearSaleData


    private function fetchMarketDashboardData($currentSaleCode){     
        // To get the number of previous sales reports needed
        $numberOfSalesReports = 2;

        // To get the number of previous sales years needed
        $numberOfYears = 2;
        $previousSaleCode = array();

        $prevdata = $this->previousSaleNumbers($currentSaleCode,$numberOfSalesReports);

        $seperateSaleCodeDetails = $this->seperateSaleCodeDetails($currentSaleCode);

        $lastYearSale = ($seperateSaleCodeDetails['year']-1).'-'.$seperateSaleCodeDetails['number'];
        $yearBeforeLastYearSale = ($seperateSaleCodeDetails['year']-2).'-'.$seperateSaleCodeDetails['number'];
        
        $yearList = array(
            'currectYear'=>$seperateSaleCodeDetails['year'],
            'lastYear'=>$seperateSaleCodeDetails['year']-1,
            'yearBeforeLastYear'=>$seperateSaleCodeDetails['year']-2,
        );
        
        array_push($previousSaleCode,$currentSaleCode);
        array_push($previousSaleCode,$prevdata[1]['sale_code']);
        array_push($previousSaleCode,$prevdata[2]['sale_code']);

        $previousData = $this->fetchMarketData($currentSaleCode);

        $prevDataArray = array();
              
        if ($previousData['yearBeforePrevYearTotalValues'] != NULL) {
            $prevDataArray['yearBeforePrevYearTotalValues']['quantity_m_kgs'] = number_format($previousData['yearBeforePrevYearTotalValues']->quantity_m_kgs,2);
            $prevDataArray['yearBeforePrevYearTotalValues']['avg_price_lkr'] = number_format($previousData['yearBeforePrevYearTotalValues']->avg_price_lkr,2);
            $prevDataArray['yearBeforePrevYearTotalValues']['avg_price_usd'] = number_format($previousData['yearBeforePrevYearTotalValues']->avg_price_usd,2);
        } else {
            $prevDataArray['yearBeforePrevYearTotalValues']['quantity_m_kgs'] = '0';
            $prevDataArray['yearBeforePrevYearTotalValues']['avg_price_lkr'] = '0';
            $prevDataArray['yearBeforePrevYearTotalValues']['avg_price_usd'] = '0';
        }
        
        
        if ($previousData['prevYearSaleTotalValues'] != NULL) {
            $prevDataArray['prevYearSaleTotalValues']['quantity_m_kgs'] = number_format($previousData['prevYearSaleTotalValues']->quantity_m_kgs,2);
            $prevDataArray['prevYearSaleTotalValues']['avg_price_lkr'] = number_format($previousData['prevYearSaleTotalValues']->avg_price_lkr,2);
            $prevDataArray['prevYearSaleTotalValues']['avg_price_usd'] = number_format($previousData['prevYearSaleTotalValues']->avg_price_usd,2);
        } else {
            $prevDataArray['prevYearSaleTotalValues']['quantity_m_kgs'] = '0';
            $prevDataArray['prevYearSaleTotalValues']['avg_price_lkr'] = '0';
            $prevDataArray['prevYearSaleTotalValues']['avg_price_usd'] = '0';
        }

        
        if ($previousData['currentTotalValues'] != NULL) {
            $prevDataArray['currentTotalValues']['quantity_m_kgs'] = number_format($previousData['currentTotalValues']->quantity_m_kgs,2);
            $prevDataArray['currentTotalValues']['avg_price_lkr'] = number_format($previousData['currentTotalValues']->avg_price_lkr,2);
            $prevDataArray['currentTotalValues']['avg_price_usd'] = number_format($previousData['currentTotalValues']->avg_price_usd,2);
        } else {
            $prevDataArray['currentTotalValues']['quantity_m_kgs'] = '0';
            $prevDataArray['currentTotalValues']['avg_price_lkr'] = '0';
            $prevDataArray['currentTotalValues']['avg_price_usd'] = '0';
        }


        if ($previousData['lastSaleYBPYdata'] != NULL) {
            $prevDataArray['lastSaleYBPYdata']['quantity_m_kgs'] = number_format($previousData['lastSaleYBPYdata']->quantity_m_kgs,2);
            $prevDataArray['lastSaleYBPYdata']['avg_price_lkr'] = number_format($previousData['lastSaleYBPYdata']->avg_price_lkr,2);
            $prevDataArray['lastSaleYBPYdata']['avg_price_usd'] = number_format($previousData['lastSaleYBPYdata']->avg_price_usd,2);
        } else {
            $prevDataArray['lastSaleYBPYdata']['quantity_m_kgs'] = '0';
            $prevDataArray['lastSaleYBPYdata']['avg_price_lkr'] = '0';
            $prevDataArray['lastSaleYBPYdata']['avg_price_usd'] = '0';
        }
        
        
        if ($previousData['lastSaleprevYdata'] != NULL) {
            $prevDataArray['lastSaleprevYdata']['quantity_m_kgs'] = number_format($previousData['lastSaleprevYdata']->quantity_m_kgs,2);
            $prevDataArray['lastSaleprevYdata']['avg_price_lkr'] = number_format($previousData['lastSaleprevYdata']->avg_price_lkr,2);
            $prevDataArray['lastSaleprevYdata']['avg_price_usd'] = number_format($previousData['lastSaleprevYdata']->avg_price_usd,2);
        } else {
            $prevDataArray['lastSaleprevYdata']['quantity_m_kgs'] = '0';
            $prevDataArray['lastSaleprevYdata']['avg_price_lkr'] = '0';
            $prevDataArray['lastSaleprevYdata']['avg_price_usd'] = '0';
        }

        
        if ($previousData['lastSaleCurrntdata'] != NULL) {
            $prevDataArray['lastSaleCurrntdata']['quantity_m_kgs'] = number_format($previousData['lastSaleCurrntdata']->quantity_m_kgs,2);
            $prevDataArray['lastSaleCurrntdata']['avg_price_lkr'] = number_format($previousData['lastSaleCurrntdata']->avg_price_lkr,2);
            $prevDataArray['lastSaleCurrntdata']['avg_price_usd'] = number_format($previousData['lastSaleCurrntdata']->avg_price_usd,2);
        } else {
            $prevDataArray['lastSaleCurrntdata']['quantity_m_kgs'] = '0';
            $prevDataArray['lastSaleCurrntdata']['avg_price_lkr'] = '0';
            $prevDataArray['lastSaleCurrntdata']['avg_price_usd'] = '0';
        }


        if ($previousData['prevLastSaleYBPYdata'] != NULL) {
            $prevDataArray['prevLastSaleYBPYdata']['quantity_m_kgs'] = number_format($previousData['prevLastSaleYBPYdata']->quantity_m_kgs,2);
            $prevDataArray['prevLastSaleYBPYdata']['avg_price_lkr'] = number_format($previousData['prevLastSaleYBPYdata']->avg_price_lkr,2);
            $prevDataArray['prevLastSaleYBPYdata']['avg_price_usd'] = number_format($previousData['prevLastSaleYBPYdata']->avg_price_usd,2);
        } else {
            $prevDataArray['prevLastSaleYBPYdata']['quantity_m_kgs'] = '0';
            $prevDataArray['prevLastSaleYBPYdata']['avg_price_lkr'] = '0';
            $prevDataArray['prevLastSaleYBPYdata']['avg_price_usd'] = '0';
        }
        
        
        if ($previousData['prevLastSaleprevYdata'] != NULL) {
            $prevDataArray['prevLastSaleprevYdata']['quantity_m_kgs'] = number_format($previousData['prevLastSaleprevYdata']->quantity_m_kgs,2);
            $prevDataArray['prevLastSaleprevYdata']['avg_price_lkr'] = number_format($previousData['prevLastSaleprevYdata']->avg_price_lkr,2);
            $prevDataArray['prevLastSaleprevYdata']['avg_price_usd'] = number_format($previousData['prevLastSaleprevYdata']->avg_price_usd,2);
        } else {
            $prevDataArray['prevLastSaleprevYdata']['quantity_m_kgs'] = '0';
            $prevDataArray['prevLastSaleprevYdata']['avg_price_lkr'] = '0';
            $prevDataArray['prevLastSaleprevYdata']['avg_price_usd'] = '0';
        }

        
        if ($previousData['prevLastSaleCurrntdata'] != NULL) {
            $prevDataArray['prevLastSaleCurrntdata']['quantity_m_kgs'] = number_format($previousData['prevLastSaleCurrntdata']->quantity_m_kgs,2);
            $prevDataArray['prevLastSaleCurrntdata']['avg_price_lkr'] = number_format($previousData['prevLastSaleCurrntdata']->avg_price_lkr,2);
            $prevDataArray['prevLastSaleCurrntdata']['avg_price_usd'] = number_format($previousData['prevLastSaleCurrntdata']->avg_price_usd,2);
        } else {
            $prevDataArray['prevLastSaleCurrntdata']['quantity_m_kgs'] = '0';
            $prevDataArray['prevLastSaleCurrntdata']['avg_price_lkr'] = '0';
            $prevDataArray['prevLastSaleCurrntdata']['avg_price_usd'] = '0';
        }
        // print_r($prevDataArray);
        $current = $previousData['currenctSaleNum'];
        $last = $previousData['lastSaleNum'];
        $saleBeforelast = $previousData['saleBeforeLastNum'];

        // print_r($last);

        return array('saleCodes'=>$previousSaleCode,
                    'previousData'=>$prevDataArray,
                    'yearList'=>$yearList,
                    'currentSale'=>$current,
                    'lastSale'=>$last,
                    'saleBeforelastSale'=>$saleBeforelast,
                );
    }    
}