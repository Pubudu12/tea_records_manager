<?php

namespace App\Http\Controllers\colomboAuctions;

use App\Http\Controllers\Controller;
use App\Http\Traits\DBOperationsTrait;
use App\Models\crop_and_weather;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CropWeatherController extends Controller
{
    use DBOperationsTrait;

    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');  
            
            return $next($request);
        });
    }

    public function getCropDetails(){

        // $cropDetails = $this->fetchDataSetBySaleCode(new crop_and_weather(),'sale_code',$this->session_sale_code);
        $cropDetails = DB::table('crop_and_weather')
                            ->where('sale_code','=',$this->session_sale_code)
                            ->where('type','=','CROP')
                            ->first();
        $weatherDetails = DB::table('crop_and_weather')
                            ->where('sale_code','=',$this->session_sale_code)
                            ->where('type','=','WEATHER')
                            ->get();
        
        $weatherTypes = [
            [
                'name'=>'Sunny',
                'code'=>'SUNNY'
            ],
            [
                'name'=>'Rainy',
                'code'=>'RAINY'
            ],
            [
                'name'=>'Gloomy',
                'code'=>'GLOOMY'
            ],
            [
                'name'=>'Cloudy',
                'code'=>'CLOUDY'
            ],
            [
                'name'=>'Windy',
                'code'=>'WINDY'
            ],
            [
                'name'=>'Stormy',
                'code'=>'STORMY'
            ]
        ];

        return view('colombo-auctions/cropAndWeather',['sale_code'=>$this->session_sale_code,'cropDetails'=>$cropDetails,'weatherDetails'=>$weatherDetails,'weatherTypes'=>$weatherTypes]);
    }//getCropDetails


    public function createCropWeather($detailsArray){
        $message = 'Please enter the given number of word count!';
        $value = 0;
        $redirect = '';
        $result = 0;
        
        $crops = new crop_and_weather();

        if (str_word_count($detailsArray['cropdesc']) > 60) {
            $message = "The maximum word count is 60 !";
        }else{
            if ($detailsArray['cropdesc'] != NULL) {
                $crops->sale_code = $this->session_sale_code;
                $crops->date_duration = $detailsArray['date_duration'];
                $crops->type = 'CROP';
                $crops->title = 'Crop';
                $crops->small_description = $detailsArray['cropdesc'];
                $res = $crops->save();
            }
        }        
        
        if ($detailsArray['region'] != NULL) {
            for ($i=0; $i < count($detailsArray['region']); $i++) { 
                if (str_word_count($detailsArray['small_desc'][$i]) > 60) {
                    $message = "The maximum word count is 60 !";
                }else{
                    $result = crop_and_weather::create([
                        'sale_code' => $this->session_sale_code,
                        'date_duration' => $detailsArray['date_duration'],
                        'type' => 'WEATHER',
                        'title' => $detailsArray['region'][$i],
                        'small_description' => $detailsArray['small_desc'][$i],
                        'weather'=>$detailsArray['weather'][$i]
                    ]);
                }               
            }          
        }
        
        if ($result) {
            $message = 'Crop & Weather updated successfully!';
            $value = 1;
            
            $redirect = '/high-grown';
            session()->put('market_analysis_elevation_id', '1');
            
        } else {
            // $message = 'Crop & Weather are not updated!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }//createCropWeather


    public function updateCropWeather($detailArray){
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;
        
        // $fetchReferences = $this->fetchData(new reference_overall_market());

        $weather = crop_and_weather::select('id','date_duration','title','small_description','weather')
                                        ->where('sale_code', '=',$this->session_sale_code)
                                        ->where('type', '=', 'WEATHER')
                                        ->get();
        
        foreach ($weather as $key => $value) {
            $res = $value->delete(); 
        }
       
        if ($detailArray['region'] != NULL) {
            for ($i=0; $i < count($detailArray['region']); $i++) { 
                if (str_word_count($detailArray['small_desc'][$i]) > 60) {
                    $message = "The maximum word count is 60 !";
                }else{
                    $result = crop_and_weather::create([
                        'sale_code' => $this->session_sale_code,
                        'date_duration' => $detailArray['date_duration'],
                        'type' => 'WEATHER',
                        'title' => $detailArray['region'][$i],
                        'small_description' => $detailArray['small_desc'][$i],
                        'weather'=>$detailArray['weather'][$i]
                    ]);
                }                
            }          
        }
        
        // Crop updates
        $crop = crop_and_weather::select('id','date_duration','title','small_description','weather')
                                        ->where('sale_code', '=',$this->session_sale_code)
                                        ->where('type', '=', 'CROP')
                                        ->first();

        $crop->date_duration = $detailArray['date_duration'];
        if (str_word_count($detailArray['cropdesc']) > 60) {
            $message = "The maximum word count is 60 !";
        }else{
            $crop->small_description = $detailArray['cropdesc'];
            $result = $crop->save();
        }        

        if ($result) {
            $message = 'Crop & Weather updated successfully!';
            $value = 1;
            
            $redirect = '/high-grown';
            session()->put('market_analysis_elevation_id', '1');
        } else {
            // $message = 'Crop & Weather is not updated!';
        }

        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }//updateCropWeather


    public function manipulateCropDetails(Request $request){
        $filedName = 'sale_code';
        $status = array();

        $region = $request->region;
        $weather = $request->weather;
        $small_desc = $request->small_desc;

        $availability = $this->fetchDataSetBySaleCode(new crop_and_weather(), $filedName, $this->session_sale_code);
        $detailArray = array('date_duration'=>$request->date_duration,'region'=>$region,'weather'=>$weather,
                                'small_desc'=>$small_desc,'cropdesc'=>$request->cropdesc);

        if (count($availability) == '0') {
            $status = $this->createCropWeather($detailArray);
        } else {
            $status = $this->updateCropWeather($detailArray);
        }
        
        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);
    }//manipulateCropDetails
}
