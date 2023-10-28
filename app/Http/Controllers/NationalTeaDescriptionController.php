<?php

namespace App\Http\Controllers;

use App\Http\Traits\DBOperationsTrait;
use App\Models\nation_wide_tea_descriptions;
use Illuminate\Http\Request;

class NationalTeaDescriptionController extends Controller
{ 

    use DBOperationsTrait;

    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');

            return $next($request);
        });
    }

    public function fetchDescriptionRecord($type){
        
        $description = nation_wide_tea_descriptions::select('*')
                                                ->where('sales_code', '=',$this->session_sale_code)
                                                ->where('type', '=', $type)
                                                ->first();

        return $description;
    }

    public function getTeaAverage(){
        $type = 'NATIONAL_TEA_SALE_AVERAGE';
        $description = $this->fetchDescriptionRecord($type);
        
        return view('tea-statistics/nationalTeaAverage',['description'=>$description]);
    }//getTeaAverage

    public function getTeaproduction(){
        $type = 'NATIONAL_TEA_PRODUCTION';
        $description = $this->fetchDescriptionRecord($type);
                
        return view('tea-statistics/nationalTeaProduction',['description'=>$description]);
    }//getTeaproduction

    public function getTeaExports(){
        $type = 'NATIONAL_TEA_EXPORT';
        $description = $this->fetchDescriptionRecord($type);
                
        return view('tea-statistics/nationalTeaExports',['description'=>$description]);
    }//getTeaExports


    public function createDescription($descArray){
        $message = '';
        $value = 0;
        $redirect = '';
    
        $desc = new nation_wide_tea_descriptions();
        $d = $descArray['description'];
        $desc->sales_code = $this->session_sale_code;
        $desc->title = $descArray['title'];
        $desc->description = $d;
        $desc->type = $descArray['type'];

        // print_r($descArray['description']);
        // $result =0;
        $result = $desc->save();

        if ($result) {
            $message = 'Description added Successfully!';
            $value = 1;
            $redirect = '/dashboard';
        } else {
            $message = 'Description is not added!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect
        );
    
    }//createDescription


    public function updateDescription($descArray){
        $message = '';
        $value = 0;
        $redirect = '';

        $description = $this->fetchDescriptionRecord($descArray['type']);
        $d = $descArray['description'];
        $description->sales_code = $this->session_sale_code;
        $description->title = $descArray['title'];
        $description->description = $d;
        // print_r($descArray['description']);
        $result = $description->save();
        // $result=0;
        if ($result) {
            $message = 'Description updated Successfully!';
            $value = 1;
            $redirect = '/dashboard';
        } else {
            $message = 'Description is not updated!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect
        );
    }//updateDescription


    public function manipulateNationalTeaDesc(Request $request){
        $status = array();

        $type = $request->type;
        $availability = $this->fetchDescriptionRecord($type);        
        
        $descArray = array('title'=>$request->title,'description'=>$request->description,'type'=>$type);
        
        if ($availability == NULL) {
            $status = $this->createDescription($descArray);
        } else {
            $status = $this->updateDescription($descArray);
        }
        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);
    }//manipulateNationalTeaDesc

}
