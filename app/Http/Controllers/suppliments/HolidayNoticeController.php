<?php

namespace App\Http\Controllers\suppliments;

use App\Http\Controllers\Controller;
use App\Http\Traits\DBOperationsTrait;
use App\Models\holiday_notices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HolidayNoticeController extends Controller
{
    use DBOperationsTrait;

    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');

            return $next($request);
        });
    }

    public function getHolidayNotice(){
        $notices = $this->fetchDetailsBySalesCode(new holiday_notices(), 'sale_code', $this->session_sale_code);

        return view('supplements/holidayNotices',['notices'=>$notices]);
    }//getHolidayNotice


    public function createHolidayNotice($request){
        $message = '';
        $value = 0;
        $redirect = '';
    
        $data = new holiday_notices();
    
        $validation = Validator::make($request->all(),[
            'title'=>['required'],
            'description'=>['required'],
        ]);
    
        if ($validation->fails()) {
            $message = 'Please Enter All Details!';
        }else{
    
            $data->sale_code = $this->session_sale_code;
            $data->title = $request->title;
            $data->description = $request->description;
    
            $result = $data->save();
    
            if ($result) {
                $message = 'Holiday Notice added Successfully!';
                $value = 1;
                $redirect = '/dashboard';
            } else {
                $message = 'Holiday Notice is not added!';
            }
        }
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect
        );
    
       }//createHolidayNotice
    
    
       public function updateHolidayNotice($request){
        $message = '';
        $value = 0;
        $redirect = '';
    
        $data = holiday_notices::where('sale_code', $this->session_sale_code)->first();
    
        $validation = Validator::make($request->all(),[
            'title'=>['required'],
            'description'=>['required'],
        ]);
    
        if ($validation->fails()) {
            $message = 'Please Enter All Details!';
        }else{
    
            
            $data->title = $request->title;
            $data->description = $request->description;
    
            $result = $data->save();
    
            if ($result) {
                $message = 'Holiday Notice updated Successfully!';
                $value = 1;
            } else {
                $message = 'Holiday Notice is not updated!';
            }
         }
    
         return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect
            );
       }//updateHolidayNotice
    
    
        public function manipulateHolidayNotices(Request $request){
            $status = array();
    
            $availability = $this->fetchDetailsBySalesCode(new holiday_notices(), 'sale_code', $this->session_sale_code);
            
            if ($availability == NULL) {
                $status = $this->createHolidayNotice($request);
            } else {
                $status = $this->updateHolidayNotice($request);
            }
            return json_encode(array(
                'message' => $status['message'],
                'result' =>$status['value'],
                'redirect'=> $status['redirect'] 
             ), 200);
        }//manipulateHolidayNotices
    
}
