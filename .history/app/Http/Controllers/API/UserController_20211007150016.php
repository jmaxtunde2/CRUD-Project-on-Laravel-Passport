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
}
