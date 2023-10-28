<?php

namespace App\Http\Controllers\_PDF\Colombo_auctions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CropWeatherController extends Controller
{
    
    public function __construct(){
        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');  
            
            return $next($request);
        });
    }

    private function getCropWhetherDetails(){
        $dataSet = DB::table('crop_and_weather')
                            ->where('sale_code','=',$this->session_sale_code)
                            ->select('type','date_duration','title','small_description','weather')
                            ->get();

         return $dataSet;

    }//getCropWhetherDetails


    public function fetchCropWhetherDetails(){
        
        $crops = $this->getCropWhetherDetails();
        
        return $crops;

    }//fetchCropWhetherDetails
}
