<?php

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

Route::group(['prefix'=>'admin/'],function ()
{
    Route::post('auth/login',[\App\Http\Controllers\Admin\AuthController::class,'login']);

});
//后台api
Route::group(['prefix'=>'admin/','middleware' => 'auth:sanctum'],function()
{
    Route::get('dashboard/panel/group/list', 'DashboardController@panelGroup');
    Route::any('auth/logout',[\App\Http\Controllers\Admin\AuthController::class,'logout']);
    Route::get('user/info',[\App\Http\Controllers\Admin\UserController::class,'info']);

    Route::get('file/list','FileController@index');
    Route::post('file/upload',[\App\Http\Controllers\Admin\FileController::class,'upload']);
    //轮播图
    Route::get('banner/list', [\App\Http\Controllers\Admin\BannerController::class,'index']);
    Route::post('banner/create', [\App\Http\Controllers\Admin\BannerController::class,'create']);
    Route::get('banner/detail/{id}', [\App\Http\Controllers\Admin\BannerController::class,'detail']);
    Route::post('banner/update/{id}', [\App\Http\Controllers\Admin\BannerController::class,'update']);
    Route::get('banner/delete/{id}', [\App\Http\Controllers\Admin\BannerController::class,'delete']);
    Route::post('banner/batch/delete',[\App\Http\Controllers\Admin\BannerController::class,'batchDelete']);

    //品牌
    Route::get('brand/list', [\App\Http\Controllers\Admin\BrandController::class,'index']);
    Route::post('brand/create', [\App\Http\Controllers\Admin\BrandController::class,'create']);
    Route::get('brand/detail/{id}', [\App\Http\Controllers\Admin\BrandController::class,'detail']);
    Route::post('brand/update/{id}', [\App\Http\Controllers\Admin\BrandController::class,'update']);
    Route::get('brand/delete/{id}', [\App\Http\Controllers\Admin\BrandController::class,'delete']);
    Route::post('brand/batch/delete',[\App\Http\Controllers\Admin\BrandController::class,'batchDelete']);

    //挖机
    Route::get('excavator/list', [\App\Http\Controllers\Admin\ExcavatorController::class,'index']);
    Route::post('excavator/create', [\App\Http\Controllers\Admin\ExcavatorController::class,'create']);
    Route::get('excavator/detail/{id}', [\App\Http\Controllers\Admin\ExcavatorController::class,'detail']);
    Route::post('excavator/update/{id}', [\App\Http\Controllers\Admin\ExcavatorController::class,'update']);
    Route::get('excavator/delete/{id}', [\App\Http\Controllers\Admin\ExcavatorController::class,'delete']);
    Route::post('excavator/batch/delete',[\App\Http\Controllers\Admin\ExcavatorController::class,'batchDelete']);
    Route::any('excavator/cost',[\App\Http\Controllers\Admin\ExcavatorController::class,'cost']);
    Route::any('excavator/visit/list',[\App\Http\Controllers\Admin\ExcavatorController::class,'visitList']);
    Route::any('excavator/collect/list',[\App\Http\Controllers\Admin\ExcavatorController::class,'collectList']);

    Route::any('reserve/list',[\App\Http\Controllers\Admin\ReserveController::class,'index']);
    Route::any('reserve/generate/order/{id}',[\App\Http\Controllers\Admin\ReserveController::class,'generateOrder']);

    Route::any('order/list',[\App\Http\Controllers\Admin\OrderController::class,'index']);

    Route::any('category/list',[\App\Http\Controllers\Admin\CategoryController::class,'index']);
    Route::any('category/list/top',[\App\Http\Controllers\Admin\CategoryController::class,'topList']);
    Route::any('category/tree',[\App\Http\Controllers\Admin\CategoryController::class,'tree']);
    Route::any('category/create',[\App\Http\Controllers\Admin\CategoryController::class,'create']);
    Route::any('category/detail/{id}',[\App\Http\Controllers\Admin\CategoryController::class,'detail']);
    Route::any('category/update/{id}',[\App\Http\Controllers\Admin\CategoryController::class,'update']);
    Route::any('category/delete/{id}',[\App\Http\Controllers\Admin\CategoryController::class,'delete']);
    Route::any('category/batch/delete',[\App\Http\Controllers\Admin\CategoryController::class,'batchDelete']);

    //地区
    Route::get('region/list', [\App\Http\Controllers\Admin\SysRegionController::class,'index']);
    Route::get('region/list/top', [\App\Http\Controllers\Admin\SysRegionController::class,'topList']);
    Route::get('region/tree', [\App\Http\Controllers\Admin\SysRegionController::class,'tree']);
    Route::post('region/create',[\App\Http\Controllers\Admin\SysRegionController::class,'create']);
    Route::get('region/detail/{id}',[\App\Http\Controllers\Admin\SysRegionController::class,'detail']);
    Route::post('region/update/{id}',[\App\Http\Controllers\Admin\SysRegionController::class,'update']);
    Route::get('region/delete/{id}',[\App\Http\Controllers\Admin\SysRegionController::class,'delete']);

});


Route::group(['middleware' => 'auth:sanctum','namespace'=>'Api'], function ()
{

    Route::get('excavator/collect/list/mine',[\App\Http\Controllers\Api\ExcavatorController::class,'mineCollectList']);
    Route::any('excavator/collect',[\App\Http\Controllers\Api\ExcavatorController::class,'collect']);

    Route::get('excavator/visit/list/mine',[\App\Http\Controllers\Api\ExcavatorController::class,'mineVisitList']);
    Route::any('excavator/visit',[\App\Http\Controllers\Api\ExcavatorController::class,'visit']);
    Route::any('excavator/reserve/list/mine',[\App\Http\Controllers\Api\ExcavatorController::class,'mineReserveList']);
    Route::any('excavator/reserve',[\App\Http\Controllers\Api\ExcavatorController::class,'reserve']);

    //绑定手机号
    Route::any('wechat/bind/phone',[\App\Http\Controllers\Api\WechatController::class,'bindPhone']);
});

//公共路由
Route::group(['namespace'=>'Api'],function (){

    Route::any('wechat/login',[\App\Http\Controllers\Api\WechatController::class,'login']);
    Route::post('auth/login',[\App\Http\Controllers\Api\AuthController::class,'login']);
    Route::any('region/city','RegionController@city');

    Route::any('banner/list', [\App\Http\Controllers\Api\BannerController::class,'index']);
    Route::any('excavator/list', [\App\Http\Controllers\Api\ExcavatorController::class,'index']);
    Route::any('excavator/brand/list', [\App\Http\Controllers\Api\BrandController::class,'index']);

    Route::any('rate',[\App\Http\Controllers\Api\IndexController::class,'rate']);

});

