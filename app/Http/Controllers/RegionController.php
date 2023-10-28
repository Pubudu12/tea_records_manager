<?php

namespace App\Http\Controllers;

use App\Http\Traits\DBOperationsTrait;
use App\Models\reference_top_prices;
use App\Models\tea_grades;
use App\Models\top_prices_regions;
use App\Models\topPrices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegionController extends Controller
{
    use DBOperationsTrait;


    public function fetchParentCategories(){
        $parentCategories = reference_top_prices::where('level', '=', '1')
                                                ->where('parent_code', '=', '')
                                                ->get();

        return $parentCategories;
    }

    public function getRegions(){
        $regions = $this->fetchParentCategories();
        return view('topPriceRegions/top-price-regions',['regions'=>$regions]);
    }//getRegions


    public function fetchChildMarks($parentCode){
        $childMarks = reference_top_prices::where('level', '=', '2')
                                        ->where('parent_code', '=', $parentCode)
                                        ->get();

        return $childMarks;
    }

   
    public function fetchRegionsById($id){        
        $data = reference_top_prices::find($id);

        $childMarks = $this->fetchChildMarks($data->code);
        
        return view('topPriceRegions/update',['data'=>$data,'childMarks'=>$childMarks]);
    }//fetchRegionsById


    public function getRegionForm(){
        $teagrades = $this->fetchData(new tea_grades());

        $parentCategories = top_prices_regions::where('level', '=', '1')
                                                ->where('parent_id', '=', '0')
                                                ->get();

        return view('topPriceRegions/create',['teagrades'=>$teagrades,'parentCategories'=>$parentCategories]);
    }//getRegionForm
    
    public function createRegion(Request $request){
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;

        $region = new top_prices_regions();

        $validation = Validator::make($request->all(),[
            'name'=>['required'],
            'order'=>['required'],
            'tea_grade'=>['required']
        ]);

        if ($validation->fails()) {
            $message = 'Please Enter All Details!';
        }else{
            $latest_id = DB::table('top_prices_regions')->orderBy('id', 'desc')->value('id');
            $code = 'TPR0000'.$latest_id;

            $region->region_name = $request->name;
            $region->tea_grade_id = $request->tea_grade;
            $region->code = $code;

            if ($request->is_subcategory == 'on') {
                $region->parent_id = $request->parent_category;
                $region->level = 2;
            }else{
                $region->parent_id = 0;
                $region->level = '1';
            }

            $region->order = $request->order;
            $res =  $region->save();

            if ($res) {
                $message = 'New Region created Successfully';
                $value = 1;
                
                $redirect = '/regions';
            } else {
                $message = 'Region is not created';
            }
        }
        return back()->with( array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        ));
    }


    public function updateRegion(Request $request){
        $message = '';
        $value = 0;
        $redirect = '';
        $res = 0;
        $data = top_prices_regions::find($request->id);

        $validation = Validator::make($request->all(), [
            'name' => ['required'],
            'order' => ['required'],
        ]);

        if ($validation->fails()) {
            $message = 'Please Enter All Details!';
        }else{
            $id = $request->id;
            $data->region_name = $request->name;
            $data->tea_grade_id = $request->tea_grade;

            if ($request->is_subcategory == 'on') {
                $data->parent_id = $request->parent_category;
                $data->level = 2;
            }else{
                $data->parent_id = 0;
                $data->level = '1';
            }

            $data->order = $request->order;
            $res =  $data->save();

            if ($res) {
                $message = 'Region updated Successfully';
                $value = 1;                
                $redirect = '/regions';

            } else {
                $message = 'Region is not updated';
            }
        }
        return back()->with( array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect
        ));
    }//updateRegion


    public function deleteRefTopPrice($id){
        $message = '';
        $value = 0;
        $redirect = '';
        $data = reference_top_prices::find($id);   
        $names = '';  

        $getchildData = DB::table('top_prices')
                            ->where('mark_code','=',$data->code)
                            ->select('id')
                            ->get();

        if (count($getchildData) > 0) {          
            $message = $data->name.' cannot be deleted! It has data included in top prices!';
        } else{
            $delete_data =  $data->delete();
        
            if($delete_data){           

                $message = 'Region deleted Successfully';
                $value = 1;
    
            }else {
                $message = 'Region is not deleted';
            }
        }       

        return json_encode(array(
            'message' => $message,
            'result' =>$value,
            'redirect'=> $redirect
         ), 200);

    }//deleteRegion


    public function addTopPriceMarks(Request $request){
        $message = 'Marks are not added!';
        $value = 0;
        $redirect = '';
        $result = 0;

        $names = $request->name;
        
        if ($names != NULL) {
            foreach ($names as $key => $value) {
                $str = substr($value, 0, 6);
                $code = $request->code.'-'.strtoupper($value);

                $is_available = DB::table('reference_top_prices')
                                        ->where('code','=',$code)
                                        ->select('id')
                                        ->first();

                if ($is_available == NULL) {
                    $result = reference_top_prices::create([
                        'name' => $value,
                        'level' => '2',
                        'code' => $code,
                        'parent_code' => $request->code,
                    ]);
                }else {
                    $message = 'This mark already available!';
                }               
            }

            if ($result) {
                $message = 'New Marks added Successfully';
                $value = 1;
                
                $redirect = '/regions';
            } 
        }        
        
        return json_encode(array(
            'message' => $message,
            'result' =>$value,
            'redirect'=> $redirect
         ), 200);
    }//addTopPriceMarks
}
