<?php

namespace App\Http\Controllers;

use App\Http\Traits\DBOperationsTrait;
use App\Models\additional_pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddNewPageController extends Controller
{

    use DBOperationsTrait;
    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');              
            return $next($request);
        });
    }

    public function fetchNewPageDetails($code = NULL){

        $detailsArray = array();
        $details = additional_pages::select('*')
                            ->where('page_type', '=',$code)
                            ->where('sale_code', '=',$this->session_sale_code)
                            ->first();  

        if ($details != NULL) {
            $detailsArray['type'] = $code;
            $detailsArray['title'] = $details->title;
            $detailsArray['content'] = $details->content;
        } else {
            $detailsArray['type'] = $code;
            $detailsArray['title'] = 'New Page Content';
            $detailsArray['content'] = '';
        }
        

        return view('addNewPage/addNewPage',['details'=>$detailsArray]);        

    }//fetchNewPageDetails

    public function createNewPageContent($request){
        $message = '';
        $value = 0;
        $redirect = '';
    
        $data = new additional_pages();
    
        $validation = Validator::make($request->all(),[
            'title'=>['required'],
            'content'=>['required'],
        ]);
    
        if ($validation->fails()) {
            $message = 'Please Enter All Details!';
        }else{
    
            $data->sale_code = $this->session_sale_code;
            $data->title = $request->title;
            $data->content = $request->content;
            $data->page_type = $request->type;
    
            $result = $data->save();
    
            if ($result) {
                $message = 'New Page Content added Successfully!';
                $value = 1;
            } else {
                $message = 'New Page Content is not added!';
            }
        }
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect
        );
    
       }//createNewPageContent
    
    
       public function updateNewPageContent($request){
        $message = '';
        $value = 0;
        $redirect = '';
    
        $data = additional_pages::where('sale_code', $this->session_sale_code)
                                ->where('page_type', $request->type)
                                ->first();
    
        $validation = Validator::make($request->all(),[
            'title'=>['required'],
            'content'=>['required'],
        ]);
    
        if ($validation->fails()) {
            $message = 'Please Enter All Details!';
        }else{    
            
            $data->title = $request->title;
            $data->content = $request->content;
    
            $result = $data->save();
    
            if ($result) {
                $message = 'New Page Content updated Successfully!';
                $value = 1;
            } else {
                $message = 'New Page Content is not updated!';
            }
         }
    
         return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect
            );
       }//updateNewPageContent
    
    
        public function manipulateNewPageContent(Request $request){
            $status = array();
    
            $availability = additional_pages::select('*')
                            ->where('page_type', '=',$request->type)
                            ->where('sale_code', '=',$this->session_sale_code)
                            ->first();
            
            if ($availability == NULL) {
                $status = $this->createNewPageContent($request);
            } else {
                $status = $this->updateNewPageContent($request);
            }
            return json_encode(array(
                'message' => $status['message'],
                'result' =>$status['value'],
                'redirect'=> $status['redirect'] 
             ), 200);
        }//manipulateHolidayNotices
    
}
