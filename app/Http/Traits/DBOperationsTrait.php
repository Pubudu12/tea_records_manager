<?php
namespace App\Http\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

trait DBOperationsTrait{

    public function fetchData($model){
        // to fetch data according to the given model
        return $model::all();
    }//fetchData()


    public function fetchDataByOrder($model,$orderByField,$order = 'asc'){
        // To fetch data by sorting with the given order
        return $model::orderBy($orderByField, $order)->get();
    }//fetchDataByOrder


    public function fetchDataByID($id){
        // $data = careers::find($id);
        // return $data;
    }//fetchDataByID


    public function fetchDataSetBySaleCode($model, $field, $value){
        return $model::where($field, '=', $value)->get();
    }//fetchDataSetBySaleCode


    public function fetchDetailsBySalesCode($model , $field, $value){
        return $model::where($field, '=', $value)->first();
    }//fetchDetailsBySalesCode


    public function checkDetailAvailability($model, $field, $value){
        $availability = $model::where($field, '=', $value)->count();
        return $availability;
    }//checkDetailAvailability

    public function fetchYearList(){
        $yearList = array();
        $startYear = 2010;

        foreach (range(date('Y'), $startYear) as $year) {
            array_push($yearList,$year);
        }

        return ($yearList);
    }//fetchYearList

    public function formDateInShortTextFormat($model , $field, $value){
        $data = $model::where($field, '=', $value)->first();

        $dayOne = strtotime(date('d-m-Y'));
        $dayTwo = strtotime(date('d-m-Y'));

        if (($data != NULL)) {
            $dayOne = $data->report_day_one;
        }

        if (($data != NULL)) {
            $dayTwo = $data->report_day_two;
        }

        $day1 = strtotime($dayOne);
        $day2 = strtotime($dayTwo); 
        $form = date("jS",$day1).' '.date("M",$day1);
        if ($day2 != NULL) {
            $form = date("jS",$day1).'/'.date("jS",$day2).' '.date("M",$day1);
        }     

        return $form;
    }//formDateInTextFormat


    public function sanitizeNumbers($numbers){
        $mainCount = count($numbers);
        $returnArray = array();

        // print_r($numbers);
        for ($i=0; $i < $mainCount; $i++) { 

            if (is_array($numbers[$i])) {
                $innerCount = count($numbers[$i]);
                for ($j=0; $j < $innerCount; $j++) { 
                    
                    $returnArray[$i][$j] = floatval(preg_replace('/[^\d.]/', '', $numbers[$i][$j]));                    
                }
            }else{
                $returnArray[$i] = floatval(preg_replace('/[^\d.]/', '', $numbers[$i]));
            }
        }
        
        return $returnArray;
    }

    public function seperateSaleCodeDetails($sale_code){
        $num = 0;
        $year = 0;
        if($sale_code != NULL){
            $pieces = str_split($sale_code,4);
            $no = str_split($pieces[1],1);
            $num = $no[1].$no[2];
            
            $year = $pieces[0];
            
            $numlength = strlen((string)$num);
            if ($num <= 0) {
                $year = $year - 1;                
            }
            if ($numlength == 1) {
                $num = '0'.$num;
            }
        }

        return array('year'=>$year,'number'=>$num,'sale_code'=>$year.'-'.$num);
    }//seperateSaleCodeDetails

    public function getPreviousSalesCode($currectSaleCode){
        $num = 0;
        $year = 0;
        if($currectSaleCode != NULL){
            $pieces = str_split($currectSaleCode,4);
            $no = str_split($pieces[1],1);
            $num = $no[1].$no[2];
            
            $year = $pieces[0];
            $num--;
            $numlength = strlen((string)$num);
            if ($num <= 0) {
                $year = $year - 1;                
            }
            if ($numlength == 1) {
                $num = '0'.$num;
            }
        }

        return array('year'=>$year,'number'=>$num,'sale_code'=>$year.'-'.$num);
    }//getPreviousSalesCode


    public function getAwaitingSaleNumber($sale_code,$sequence){
        $pieces = str_split($sale_code,4);
        $no = str_split($pieces[1],1);
        $awaiting_sale_code = $no[1].$no[2];
       
        $awaiting_sale_code = $awaiting_sale_code+$sequence;
       
        if (strlen($awaiting_sale_code) == 1) {
            $awaiting_sale_code = '0'.$awaiting_sale_code;
        }
        $awaiting_sale_code = $pieces[0].'-'.$awaiting_sale_code;
        
        return $awaiting_sale_code;
       
    }//getAwaitingSaleNumber


    public function formDateInTextFormat($model , $field, $value){
        $data = $model::where($field, '=', $value)->first();
        $day1 = strtotime($data->report_day_one);
        $day2 = strtotime($data->report_day_two); 
        $form = date("jS",$day1).' '.date("F",$day1);
        if ($day2 != NULL) {
            $form = date("jS",$day1).'/'.date("jS",$day2).' '.date("F",$day1);
        }     

        return $form;
    }//formDateInTextFormat


    public function calculateTodateValues($values, $table ,$sale_code){
        $year = 0;
        $num = 0;
        $availableSaleNumbers = array();
        $data = array();

        if($sale_code != NULL){
            $pieces = str_split($sale_code,4);
             
            // get report year
            $year = $pieces[0];       
            
            $no = str_split($pieces[1],1);
            $num = $no[1].$no[2];
        }

        // get the previous sale numbers
        $previousSaleNumbers = 1;
        while ($previousSaleNumbers <= $num) {
            if (strlen($previousSaleNumbers) == 1) {
                $previousSaleNumbers = '0'.$previousSaleNumbers;
            }
            // $availableSaleNumbers = $year.'-'.$previousSaleNumbers.' ';
            $saleCode = $year.'-'.$previousSaleNumbers;
            // array_push($availableSaleNumbers, $year.'-'.$previousSaleNumbers);
            $data[$previousSaleNumbers] = DB::table($table)
                                            ->where('sales_code','=',$saleCode)
                                            ->select('todate_price_kgs')
                                            ->get();
            
            $previousSaleNumbers++;
        }

        // $saleNumberList = implode("','", $availableSaleNumbers);
        // $saleNumberList = "['".$saleNumberList."']";      
        // print_r($saleNumberList);
        $totArray = array();

        foreach ($data as $key => $value) {
            // print_r($value);
            // print_r('<br><br>');

            if (!is_null($value)) {
                $i = 0;
                foreach ($value as $innerkey => $innerValue) {

                    // $totArray[$innerkey] = 0;
                    $totArray[$key][$innerkey] = $innerValue->todate_price_kgs;

                    // $totArray[$innerkey] + $innerValue->todate_price_kgs;

                    print_r($innerValue);
                    print_r('<br><br>');
                    $i++;
                }
            }
        }

        $v = array();
        print_r($totArray);
        print_r('<br><br>');
        foreach ($totArray as $key => $value) {
            foreach ($value as $innerkey => $inner) {
                $v[$key][$innerkey] = 2;
                $v[$key][$innerkey] = $v[$key][$innerkey] + $inner;
            }
        }

        print_r($v);

        // $data = DB::table($table)
        //             ->whereIn('sales_code',['2022-01','2022-02','2022-03','2022-04','2022-05','2022-06','2022-07','2022-08','2022-09','2022-10'])
        //             ->select('todate_price_kgs')
        //             ->get();

        return $year;

    }//calculateTodateValues
}