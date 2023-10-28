<?php

namespace App\Http\Controllers;

use App\Http\Traits\DBOperationsTrait;
use App\Models\tea_market_descriptions;
use Illuminate\Http\Request;

class WorldTeaDescriptionController extends Controller
{
    use DBOperationsTrait;

    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');

            return $next($request);
        });
    }

    
    public function getTeaMarketDescriptions(){
        $filedName = 'sale_code';        

        $marketDescriptions = $this->fetchDataSetBySaleCode(new tea_market_descriptions(), 'sales_code', $this->session_sale_code);
        
        return view('/world-tea-auctions/worldTeaDescriptions',['marketDescriptions'=>$marketDescriptions,'sale_code'=>$this->session_sale_code]);
    }//fetchAuctionDescriptions


    public function createTeaMarketDescription($titles, $description){
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;

        $overall = new tea_market_descriptions();
        foreach ($titles as $key => $singleDesc) {  
            // print_r($description[$key])   ;
            $result = tea_market_descriptions::create([
                'sales_code' => $this->session_sale_code,
                'title' => $singleDesc,
                'description' => $description[$key]
                // $desc = str_replace("fade", "", $desc);
            ]);
        }

        if ($result) {
            $message = 'Tea Market Descriptions added successfully!';
            $value = 1;
            
            $redirect = '/dashboard';
        } else {
            $message = 'Tea Market Descriptions are not added!';
        }
        
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }//createTeaMarketDescription


    public function updateTeaMarketDescription($titles, $description){
        $message = '';
        $value = 0;
        $redirect = '';
        $result = 0;
        $longDesc = tea_market_descriptions::select('id','title','description')
                                            ->where('sales_code', '=',$this->session_sale_code)
                                            ->get();

        if (count($longDesc) > 0) {
            foreach ($longDesc as $key => $value) {
                $data = tea_market_descriptions::find($value->id);                                
                $delete_data =  $data->delete();
            }
        }
        
        foreach ($titles as $key => $singleDesc) {  
            // print_r($description[$key])   ;
            $result = tea_market_descriptions::create([
                'sales_code' => $this->session_sale_code,
                'title' => $singleDesc,
                'description' => $description[$key]
            ]);
        }

        if ($result) {
            $message = 'Tea Market Descriptions updated successfully!';
            $value = 1;
            
            $redirect = '/dashboard';
        } else {
            $message = 'Tea Market Descriptions are not updated!';
        }
        
        return array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect            
        );
    }//updateTeaMarketDescription


    public function manipulateTeaMarketDescriptions(Request $request){
        $filedName = 'sale_code';
        $status = array();

        $descriptions = $this->fetchDataSetBySaleCode(new tea_market_descriptions(), 'sales_code', $this->session_sale_code);
        
        $title = $request->title;
        $description = $request->desc;

        if (count($descriptions) > 0) {
            $status = $this->updateTeaMarketDescription($title, $description);
        } else {
            $status = $this->createTeaMarketDescription($title, $description);
        }
        
        return json_encode(array(
            'message' => $status['message'],
            'result' =>$status['value'],
            'redirect'=> $status['redirect'] 
         ), 200);
    }//manipulateAuctionDesc
}
