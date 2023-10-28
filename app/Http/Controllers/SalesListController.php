<?php

namespace App\Http\Controllers;

use App\Http\Traits\DBOperationsTrait;
use App\Models\months;
use App\Models\sales_list;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SalesListController extends Controller
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


    public function fetchCreateReportForm(){
        $yearList = array();
        $yearList = $this->fetchYearList();
        $monthList = $this->fetchMonthList();
        return view('report-Dashboard/create',['yearList'=>$yearList,'monthList'=>$monthList]);
    }//fetchCreateReportForm


    public function getSalesList(){
        $salesList = $this->fetchData(new sales_list());
        $yearList = $this->fetchYearList();
        session()->forget('SelectedSaleCode');
        return view('/report-Dashboard/index',['salesList'=>$salesList,'yearList'=>$yearList]);
    }//getSalesList


    public function getUpdatPageDetails($salecode){
        $yearList = array();
        $filedName = 'sales_code';

        $fetchsalesDetails = $this->fetchDetailsBySalesCode(new sales_list(), $filedName, $salecode);

        // Set Sales Code
        $this->setSalesCodeSession($salecode);

        $yearList = $this->fetchYearList();
        $monthList = $this->fetchMonthList();

        return view('report-Dashboard/update',['yearList'=>$yearList,'monthList'=>$monthList,'salesDetails'=>$fetchsalesDetails,'salecode'=>$salecode]);
    }//getUpdatPageDetails


    public function fetchSaleById($id){
        $data = sales_list::find($id);
        return view('cm',['data'=>$data]);
    }//fetchSaleById


    public function createReport(Request $request){
        $message = '';
        $value = 0;
        $redirect = '';

        $report = new sales_list();

        $validation = Validator::make($request->all(),[
            'title'=>['required'],
            'year'=>['required'],
            'month'=>['required'],
        ]);

        $saleNumValidation = Validator::make($request->all(),[
            'sale_number'=>['digits_between:2,2']
        ]);

        if ($validation->fails()) {
            $message = 'Please Enter All Details!';
        }elseif ($saleNumValidation->fails()) {
            $message = 'Please use two figures as the sale number!';
        }else{
            $latest_id = DB::table('sales_list')->orderBy('sales_id', 'desc')->value('sales_id');
            $sales_id = $latest_id+1;
            $code = $request->year.'-'.$request->sale_number;

            $availability = $this->fetchDetailsBySalesCode(new sales_list(), 'sales_code',$code);

            if ($availability != NULL) {
                $message = 'This sale code is already available!';
            }else{
                $report->sales_id = $sales_id;
                $report->title = $request->title;
                $report->year = $request->year;
                $report->month = $request->month;
                $report->sales_no = $request->sale_number;
                $report->sales_code = $code;
                $report->current_dollar_value = $request->current_dollar_value;
                $report->report_day_one = $request->report_day_one;
                $report->report_day_two = $request->report_day_two;
                $report->published = 1 ;
                $report->published_date = $request->publish_date;

                $result = $report->save();

                if ($result) {
                    $message = 'New Report created Successfully!';
                    $value = 1;

                    // Set Session Code
                    $this->setSalesCodeSession($code);

                    $redirect = '/reportDashboard';
                } else {
                    $message = 'Report is not created!';
                }
            }

        }
        return json_encode(array(
            'message' => $message,
            'result' => $value,
            'redirect'=> $redirect
        ),200);
    }//createReport


    public function updateReport(Request $request){
        $message = '';
        $value = 0;
        $redirect = '';

        $data = sales_list::find($request->sale_id);

        $validation = Validator::make($request->all(),[
             'title'=>['required'],
             'year'=>['required'],
             'month'=>['required'],
        ]);

        if ($validation->fails()) {
             $message = 'Please Enter all details!';
        }else{

            $data->title = $request->title;
            $data->year = $request->year;
            $data->month = $request->month;
            $data->sales_no = $request->sale_number;
            $data->report_day_one = $request->report_day_one;
            $data->report_day_two = $request->report_day_two;
            $data->current_dollar_value = $request->current_dollar_value;
            $data->published_date = $request->publish_date;

            $result = $data->save();
            
            
            if ($result) {
                $message = 'Report updated Successfully!';
                $value = 1;
            } else {
                $message = 'Report is not updated!';
            }
        }

        return json_encode(array(
            'message' => $message,
            'result' => $value,
        ), 200);

    }


    public function setSalesCodeSession($saleCode){

        // OLD SESSION
        session()->forget('sale_code');
        session()->put('sale_code', $saleCode);

        // NEW SESSION
        session()->forget('SelectedSaleCode');
        session()->put('SelectedSaleCode', $saleCode);
        return true;

    }

}
