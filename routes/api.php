<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::namespace('Api')->group(function (){

    //后台api
    Route::prefix('admin/')->namespace('Backend')->group(function(){

        Route::post('user/login','UserController@login');
        Route::get('user/logout','UserController@logout');
        Route::get('user/info','UserController@info');
    });
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
