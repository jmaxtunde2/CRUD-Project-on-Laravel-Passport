<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login'])->name('login');


Route::group(["middleware" => "auth:api"], function () {
   
    //User
    Route::group(["prefix" => "user"], function () {
        Route::post('changepassword', [UserController::class, 'changePassword']);
        Route::post('list', [UserController::class, 'listUsers']);
        Route::get('logout', [UserController::class, 'logout']);
        Route::post('update/{id}', [UserController::class, 'updateUser']);
    });
});

