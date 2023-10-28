<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaveGraphASImageController extends Controller
{

    public function saveGraphAsImage(Request $request){

        $imageName = $request->image_name;
        $file = $request->file;

        $img = $file;
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        file_put_contents('charts/charts.jpg', $data);

        // file_put_contents('charts/charts.jpg', base64_decode($file));

        return json_encode(array(
            'message' => 'Hello from server',
            'req' => $request,
            'imageName' => $imageName,
            'file'=> $file
        ));

        return back()->with( array(

        ));


    } //saveGraphAsImage

}
