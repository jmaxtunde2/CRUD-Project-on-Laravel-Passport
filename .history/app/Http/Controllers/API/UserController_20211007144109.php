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
            'role' => ['required'],
        ]);

        //
        if($validator->fails()){
            $error = $validator->messages()->first();
            return $this->response(false, $error, 400);
        }
    }
}
