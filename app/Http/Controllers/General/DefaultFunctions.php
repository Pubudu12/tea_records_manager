<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DefaultFunctions extends Controller
{
    //

    public static function comboBoxSelected($data1, $data2){

        $data1 = trim($data1);
        $data2 = trim($data2);

        if($data1 == $data2){
            return "selected";
        }

    }

    public static function IsCompareChecked($data1, $data2){

        $data1 = trim($data1);
        $data2 = trim($data2);

        if($data1 == $data2){
            return "checked";
        }else{
            return '';
        }

    } //IsCompareChecked

    public static function IsCheckedInput($booleanData){

        $booleanData = trim($booleanData);

        if($booleanData == 1 || $booleanData == true){
            return "checked";
        }

    }

}
