<?php

namespace App\Http\Controllers;

use App\Http\Traits\DBOperationsTrait;
use App\Models\import_countries;
use App\Models\major_importers_details;
use App\Models\world_tea_production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ImportCountriesController extends Controller
{
    use DBOperationsTrait;

    public function getCountries(){
        $countries = $this->fetchData(new import_countries());
        return view('/countries/countries',['countries'=>$countries]);
    }//getCountries


    public function fetchCountriesById($id){
        $data = import_countries::find($id);
        return view('countries/update',['data'=>$data]);
    }


    public function createCountry(Request $request){
        $message = '';
        $value = 0;
        $redirect = '';
        $country = new import_countries();

        $validation = Validator::make($request->all(), [
            'name' => ['required'],
        ]);

        if ($validation->fails()) {
            $message = 'Please Enter All Details!';
        }else{
            $latest_id = DB::table('import_countries')->orderBy('id', 'desc')->value('id');
            $code = 'C0000'.$latest_id;

            $country->name = $request->name;
            $country->keyword = strtoupper($request->name);
            $country->code = $code;

            $res = $country->save();

            if ($res) {
                $message = 'New country created Successfully';
                $value = 1;
                $redirect = '/countries';

            } else {
                $message = 'Country is not created';
            }
        }
        return json_encode(array(
            'message' => $message,
            'result' =>$value,
            'redirect'=> $redirect 
         ), 200);
    }//createCountry


    public function updateCountry(Request $request){
        $message = '';
        $value = 0;
        $redirect = '';
        $country = import_countries::find($request->id);

        $validation = Validator::make($request->all(), [
            'name' => ['required'],
        ]);

        if ($validation->fails()) {
            $message = 'Please Enter All Details!';
        }else{

            // $id = $request->id;
            $country->name = $request->name;
            // $country->keyword = strtoupper($request->name);

            $res = $country->save();

            if ($res) {
                $message = 'Country updated Successfully';
                $value = 1;
                $redirect = '/countries';
            } else {
                $message = 'Country is not updated';
            }
        }
        return json_encode(array(
            'message' => $message,
            'result' =>$value,
            'redirect'=> $redirect 
         ), 200);
    }//updateCountry


    public function deleteCountry($id){
        $message = '';
        $value = 0;
        $redirect = '';
        $data = import_countries::find($id);

        $majorImporters = major_importers_details::select('id')
                                            ->where('country_id', '=',$id)
                                            ->get();

        $teaProdCountries = world_tea_production::select('id')
                                            ->where('country_id', '=',$id)
                                            ->get();

        if ((count($majorImporters) > 0) & (count($teaProdCountries) > 0)) {
            $message = 'This Country has data in other tables! Cannot be deleted!';
        }else {
            $delete_data =  $data->delete();
            if($delete_data){

                $message = 'Country deleted Successfully';
                $value = 1;

            }else {
                $message = 'Country is not deleted';
            }
        }        

        return json_encode(array(
            'message' => $message,
            'result' =>$value,
            'redirect'=> $redirect 
         ), 200);
    }//deleteCountry
}
