<?php

namespace App\Http\Controllers;

use App\Http\Traits\DBOperationsTrait;
use App\Models\tea_grades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GradesController extends Controller
{
    use DBOperationsTrait;

    public function fetchTeaGrades(){
        $teaGrades = $this->fetchData(new tea_grades());
        return view('tea-grades/teaGrades',['teaGrades'=>$teaGrades]);
    }//fetchTeaGrades


    public function fetchTeaGradesById($id){
        $data = tea_grades::find($id);
        return view('tea-grades/update',['data'=>$data]);
    }//fetchTeaGradesById


    public function createTeaGrade(Request $request){
        $message = '';
        $value = 0;
        $redirect = '';
        $teaGrade = new tea_grades();

        $validation = Validator::make($request->all(), [
            'name' => ['required'],
            'keyword' => ['required'],
        ]);

        if ($validation->fails()) {
            $message = 'Please Enter All Details!';
        }else{

            $latest_id = DB::table('tea_grades')->orderBy('id', 'desc')->value('id');
            $code = 'TG0000'.$latest_id;

            $teaGrade->name = $request->name;
            $teaGrade->keyword = $request->keyword;
            $teaGrade->code = $code;

            $res = $teaGrade->save();

            if ($res) {
                $message = 'New Tea Grade created Successfully';
                $value = 1;
                $redirect = '/tea-grades';
            } else {
                $message = 'Tea Grade is not created';
            }
        }
        return back()->with( array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect
        ));
    }//createTeaGrade


    public function updateTeaGrade(Request $request){
        $message = '';
        $value = 0;
        $redirect = '';
        $data = tea_grades::find($request->id);

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

            $res =  $data->save();

            if ($res) {
                $message = 'Tea Grade updated Successfully';
                $value = 1;
                $redirect = '/tea-grades';

            } else {
                $message = 'Tea Grade is not updated';
            }
        }
        return back()->with( array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect
        ));
   }//updateTeaGrade


    function deleteTeaGrade($id){

        $message = '';
        $value = 0;
        $redirect = '';
        $data = tea_grades::find($id);

        $delete_data =  $data->delete();

        if($delete_data){

            $message = 'Tea Grade deleted Successfully';
            $value = 1;

        }else {
            $message = 'Tea Grade is not deleted';
        }

        return back()->with( array(
            'message' => $message,
            'value' => $value,
            'redirect'=> $redirect
        ));

    }//deleteTeaGrade()
}
