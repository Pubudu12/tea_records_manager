<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{

    private $statusCode = 200;
    private $message = "";
    private $result = 0;
    private $redirect = '';

    public function showLogin() {
        return view('account/login');
    }

    public function doLogin(Request $request) {

        $this->message = "Failed to login";

        $rules = array(
            'email' => 'required', // make sure the email is an actual email
            'password' => 'required' // password can only be alphanumeric and has to be greater than 3 characters
        );

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){

            $this->message = $validator->errors()->all();
            return response()->json(['message'=>$this->message, 'result' => $this->result]);

        }

        $input = $request->all();

        $userdata = array(
            'email'     => $input['email'],
            'password'  => $input['password']
        );

        if (Auth::attempt($userdata)) {

            $this->setSession();

            $this->message = "User has been logged in successfully";
            $this->result = 1;
            $this->redirect = '/dashboard';

        }else{
            $this->message = "User email or password is wrong";
        }
        
        return response()->json(['message'=>$this->message, 'result' => $this->result,'redirect'=>$this->redirect]);

    } // Login Close

    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){

            $this->message = $validator->errors()->all();
            return response()->json(['message'=>$this->message, 'result' => $this->result]);

        }

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);

        $checkEmail = User::where('email', '=' , $input['email'])->first();

        if($checkEmail !== Null){

            // Email Already Exist
            $this->message = "Email address already exist";
            return response()->json(['message'=>$this->message, 'result' => $this->result]);
        }


        $registerUser = User::create(['email'=>$input['email'], 'password'=>$input['password'], 'name'=>$input['name'], 'published'=>'1', 'role'=>$input['role']]);

        if($registerUser){
            $this->message = "New user has been registered";
            $this->result = 1;
        }else{
            $this->message = "Failed to register new user";
        }

        // Success Message to Create STD Page
        return response()->json(['message'=>$this->message, 'result' => $this->result]);

    }

    public function showUpdateUser($userid){

        $user = User::find($userid);

        return view('users.updateUsers', ['user'=>$user]);

    } //showUpdateUser

    public function updateUser(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'required_with_all|min:6',
            'c_password' => 'same:password',
        ]);

        if($validator->fails()){

            $this->message = $validator->errors()->all();
            return response()->json(['message'=>$this->message, 'result' => $this->result]);

        }

        $input = $request->all();
        $user_id = $input['user_id'];

        $checkEmail = User::where('email', '=' , $input['email'])->where('id', '!=', $user_id )->first();

        if($checkEmail !== Null){

            // Email Already Exist
            $this->message = "Email address already exist";
            return response()->json(['message'=>$this->message, 'result' => $this->result]);
        }

        $updateUserArray = array('email'=>$input['email'], 'name'=>$input['name'], 'role'=>$input['role']);
        if(strlen($input['password']) > 0){
            $input['password'] = Hash::make($input['password']);
            $updateUserArray['password'] = $input['password'];
        }

        $updateUser = User::create($updateUserArray);

        if($updateUser){
            $this->message = "User details has been updated";
            $this->result = 1;
        }else{
            $this->message = "Failed to update user details";
        }

        // Success Message to Create STD Page
        return response()->json(['message'=>$this->message, 'result' => $this->result]);

    } // updateUser

    public function showUserList(){

        $allUsers = User::all();

        return View('users/users', ['users'=>$allUsers]);

    } /// Show User List


    public function changesPassword(Request $request){

        // validate the info, create rules for the inputs
        $rules = array(
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:new_password'
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::to('change_password')
                ->withErrors($validator);
        } else {

            // create our user data for the authentication
            $userdata = array(
                'current_password' => $request['current_password'],
                'new_password' => $request['new_password'],
                'confirm_password' => $request['confirm_password']
            );


            $current_password = Auth::User()->password;
            if( Hash::check($userdata['current_password'], $current_password) ) {

                $user_id = Auth::User()->id;
                $obj_user = User::find($user_id);
                $obj_user->password = Hash::make($userdata['new_password']);
                $obj_user->save();


                $error = array('success' => 'Your password has been changed successfully.');
                return Redirect::to('change_password')
                ->withErrors($error);

            }else{

                $error = array('current_password' => 'Please enter correct current password');
                return Redirect::to('change_password')
                ->withErrors($error);
            }


        } // validation check

    }


    public function deleteUser($id){
        $message = '';
        $value = 0;
        $redirect = '';
        $data = User::find($id);
        $delete_data =  $data->delete();
        if($delete_data){

            $message = 'User deleted Successfully';
            $value = 1;

        }else {
            $message = 'User is not deleted';
        }

        return json_encode(array(
            'message' => $message,
            'result' =>$value,
            'redirect'=> $redirect 
         ), 200);
    }//deleteUser


    public function doLogout() {

        Auth::logout();

        $this->removeSessions();

        return Redirect::to('/');

    }


    private function setSession(){

        $users_details = Auth::user();
        $id = $users_details['id'];

        Session::put('userId', $id);
        Session::put('userRole', $users_details['role']);
        Session::put('userName', $users_details['name']);

    }

    private function removeSessions(){
        Session::forget('user_id');
        Session::forget('user_type');
        Session::forget('name');
    }

}
