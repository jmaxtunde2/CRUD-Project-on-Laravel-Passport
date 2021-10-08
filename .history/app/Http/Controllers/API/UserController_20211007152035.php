<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:5', 'max:50'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required','string', 'unique:users,phone'],
            'password' => ['min:6', 'required', 'confirmed'],
        ]);

        //
        if($validator->fails()){
            $error = $validator->messages()->first();
            return $this->response(false, $error, 400);
        }

        try{

            $postData = $request->all();
            //

            $postData['password'] = Hash::make($postData['password']);

            //

            $user = User::create($postData);

            //

            $token = $user->createToken('authToken')->accessToken;

           //
            return response([
                'success' => true,
                'message' => 'User registered successfully',                
                'token' => $token,
            ]);
        }catch(Exception $exception){

            return $this->response(false, $exception->getMessage(), 400);

        }
    }

    public function login(Request $request)
    {
        $login_credentials=[
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        if(Auth::attempt($login_credentials)){
            //
            $user_token= $user->createToken('authToken')->accessToken;
            
            //$user->token = $user_token->token;
            //now return this token on success login attempt
            return response()->json(['message' =>'Login successfull','API token' => $user_token->token], 200);
        }
        else{
            //wrong login credentials, 
            return response()->json(['error' => 'UnAuthorised Access'], 401);
        }
    }

    // Update user
    public function updateUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:5', 'max:50'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'string', 'unique:users,phone'],

        ]);
        //
        if ($validator->fails()) {
            $error = $validator->messages()->first();
            return $this->response(false, $error, 400);
        }
        //
        try{
            $postData = $request->all();
            //
            $user = User::where('id', $id)->first();
            $user->update($postData);

            return $this->response(true, "User updated", 200);
        }catch(Exception $exception){
            return $this->response(false, $exception->getMessage(), 400);
        }

    }

    public function changePassword(Request $request)
    {
        $input = $request->all();
        $userid = Auth::guard('api')->user()->id;

        $validator = Validator::make($request->all(), [
            'old_password' => ['required', 'string', 'min:5', 'max:50'],
            'new_password' => ['required', 'email', 'unique:users,email'],
            'confirm_password' => ['required', 'string', 'same:new_password'],
        ]);
        //
        if ($validator->fails()) {
            $error = $validator->messages()->first();
            return $this->response(false, $error, 400);
        }

            try {
                if ((Hash::check(request('old_password'), Auth::user()->password)) == false) 
                {
                    //
                    return response()->json(['error' => 'Old Password incorrect'], 400);

                } else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) 
                {
                    //
                    return response()->json(['error' => 'Please enter a password which is not similar to the current password.'], 400);

                } else {
                    User::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                    return response()->json(['message' => 'Password updated successfully'], 200);
                }
            } catch (\Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                $arr = array("status" => 400, "message" => $msg, "data" => array());
            }
       
    }

}
