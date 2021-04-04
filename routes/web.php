<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=>'admin/'],function (){

    Route::get('/',[\App\Http\Controllers\Admin\DashboardController::class,'index']);
    Route::get('auth/login',[\App\Http\Controllers\Admin\Auth\AuthController::class,'login']);


    Route::get('test/test',[\App\Http\Controllers\TestController::class,'test']);
    Route::get('test/antprotestone',[\App\Http\Controllers\TestController::class,'antProTestOne']);
    Route::get('test/antprotesttwo',[\App\Http\Controllers\TestController::class,'antProTestTwo']);


});

