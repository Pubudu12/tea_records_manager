<?php

namespace App\Http\Controllers;

use App\Http\Traits\DBOperationsTrait;
use App\Models\highlights_description;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HighlightsDescriptionController extends Controller
{
    use DBOperationsTrait;

    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');

            return $next($request);
        });
    }

    public function getHighlightDescription(){
        $highlights = $this->fetchDetailsBySalesCode(new highlights_description(), 'sales_code', $this->session_sale_code);

        return view('supplements/highlights',['highlights'=>$highlights]);
    }//getHighlightDescription


    public function createHighlight($request){
        $message = '';
        $value = 0;
        $redirect = '';
    
        $data = new highlights_description();
    
        $validation = Validator::make($request->all(),[
            'title'=>['required'],
            'description'=>['required'],
        ]);
    
        if ($validation->fails()) {
            $message = 'Please Enter All Details!';
        }else{
    
            $data->sales_code = $this->session_sale_code;
            $data->title = $request->title;
            $data->description = $request->description;
    
            $result = $data->save();
    
            if ($result) {
                $message = 'Description added Successfully!';
                $value = 1;
                $redirect = '/dashboard';
            } else {
                $message = 'Description are not added!';
            }
        }
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect
        );
    
       }//createHighlight
    
    
       public function updateHighlight($request){
        $message = '';
        $value = 0;
        $redirect = '';
    
        $data = highlights_description::where('sales_code', $this->session_sale_code)->first();
    
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
                $message = 'Description updated Successfully!';
                $value = 1;
            } else {
                $message = 'Description are not updated!';
            }
         }
    
         return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect
            );
       }//updateHighlight
    
    
        public function manipulateHighlightDesc(Request $request){
            $status = array();
    
            $availability = $this->fetchDetailsBySalesCode(new highlights_description(), 'sales_code', $this->session_sale_code);
            
            if ($availability == NULL) {
                $status = $this->createHighlight($request);
            } else {
                $status = $this->updateHighlight($request);
            }
            return json_encode(array(
                'message' => $status['message'],
                'result' =>$status['value'],
                'redirect'=> $status['redirect'] 
             ), 200);
        }//manipulateHighlightDesc
    
}
