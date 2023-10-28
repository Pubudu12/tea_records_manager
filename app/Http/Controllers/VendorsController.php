<?php

namespace App\Http\Controllers;

use App\Http\Traits\DBOperationsTrait;
use App\Models\vendors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VendorsController extends Controller
{
    use DBOperationsTrait;

    public function getVendors(){
        $vendors = $this->fetchData(new vendors());        
        return view('vendors/vendors',['vendors'=>$vendors]);        
    }//getVendors


    public function fetchVendorById($id){
        $data = vendors::find($id);
        return view('vendors/update',['data'=>$data]);
    }//fetchVendorById


    public function createVendor(Request $request){
        $message = '';
        $value = 0;
        $redirect = '';
        $vendor = new vendors();

        $validation = Validator::make($request->all(), [
            'name' => ['required'],
            'keyword' => ['required'],
        ]);
        
        if ($validation->fails()) {
            $message = 'Please Enter All Details!';
        }else{
            
            $latest_id = DB::table('vendors')->orderBy('id', 'desc')->value('id');
            $code = 'V0000'.$latest_id;

            $vendor->name = $request->name;
            $vendor->keyword = $request->keyword;
            $vendor->code = $code;
            // $vendor->order = $request->order;

            $res = $vendor->save();
            
            if ($res) {
                $message = 'New Vendor created Successfully';
                $value = 1;
                $redirect = '/vendors';
            } else {
                $message = 'Vendor is not created';
            }
        }
        return json_encode(array(
            'message' => $message,
            'result' =>$value,
            'redirect'=> $redirect 
         ), 200);
    }


    public function updateVendor(Request $request){
        $message = '';
        $value = 0;
        $redirect = '';
        $data = vendors::find($request->id);

        $validation = Validator::make($request->all(), [
            'name' => ['required'],
            'keyword' => ['required'],
        ]);

        if ($validation->fails()) {
            $message = 'Please Enter All Details!';
        }else{
            $id = $request->id;
            $data->name = $request->name;
            $data->keyword = $request->keyword;
            // $data->order = $request->order;

            $res =  $data->save();

            if ($res) {
                $message = 'Vendor updated Successfully';
                $value = 1;                
                $redirect = '/vendors';

            } else {
                $message = 'Vendor is not updated';
            }
        }
        
        return json_encode(array(
            'message' => $message,
            'result' =>$value,
            'redirect'=> $redirect 
         ), 200);
   }


    function deleteVendor(Request $request){
            
        $message = '';
        $value = 0;
        $redirect = '';
        $data = vendors::find($request->id);                                
        $delete_data =  $data->delete();
        if($delete_data){           

            $message = 'Vendor deleted Successfully';
            $value = 1;
            $redirect = '/vendors';

        }else {
            $message = 'Vendor is not deleted';            
        }
        
        return json_encode(array(
            'message' => $message,
            'result' =>$value,
            'redirect'=> $redirect 
         ), 200);

    }//deleteCountry()
}
