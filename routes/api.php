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
Route::group(['prefix'=>'admin/','namespace'=>'Admin'],function ()
{
    Route::post('auth/login','AuthController@login');

});
//后台api
Route::group(['prefix'=>'admin/','namespace'=>'Admin','middleware' => 'auth:sanctum'],function()
{
    Route::get('auth/logout','AuthController@logout');
    Route::get('user/info','UserController@info');

    Route::get('file/list','FileController@index');
    Route::post('file/upload','FileController@upload');
    //轮播图
    Route::get('banner/list', 'BannerController@index');
    Route::post('banner/create', 'BannerController@create');
    Route::get('banner/detail/{id}', 'BannerController@detail');
    Route::post('banner/update/{id}', 'BannerController@update');
    Route::get('banner/delete/{id}', 'BannerController@destroy');
    Route::post('banner/batch/delete','BannerController@batchDelete');

    //品牌
    Route::get('brand/list', 'BrandController@index');
    Route::post('brand/create', 'BrandController@store');
    Route::get('brand/detail/{id}', 'BrandController@show');
    Route::post('brand/update/{id}', 'BrandController@update');
    Route::get('brand/delete/{id}', 'BrandController@destroy');
    Route::post('brand/batch/delete','BrandController@batchDelete');

    //挖机
    Route::get('excavator/list', 'ExcavatorController@index');
    Route::post('excavator/create', 'ExcavatorController@create');
    Route::get('excavator/detail/{id}', 'ExcavatorController@detail');
    Route::post('excavator/update/{id}', 'ExcavatorController@update');
    Route::get('excavator/delete/{id}', 'ExcavatorController@destroy');
    Route::post('excavator/batch/delete','ExcavatorController@batchDelete');
    Route::any('excavator/cost','ExcavatorController@cost');


    Route::any('category/list','CategoryController@index');
    Route::any('category/list/top','CategoryController@topList');
    Route::any('category/tree','CategoryController@tree');
    Route::any('category/create','CategoryController@create');
    Route::any('category/detail/{id}','CategoryController@detail');
    Route::any('category/update/{id}','CategoryController@update');
    Route::any('category/delete/{id}','CategoryController@delete');
    Route::any('category/batch/delete','CategoryController@batchDelete');

    //地区
    Route::get('region/list', 'SysRegionController@index');
    Route::get('region/list/top', 'SysRegionController@topList');
    Route::get('region/tree', 'SysRegionController@tree');
    Route::post('region/create', 'SysRegionController@create');
    Route::get('region/detail/{id}', 'SysRegionController@detail');
    Route::post('region/update/{id}', 'SysRegionController@update');
    Route::get('region/delete/{id}', 'SysRegionController@delete');

});


Route::group(['middleware' => 'auth:sanctum','namespace'=>'Api'], function ()
{

    Route::get('excavator/collect/list/mine','ExcavatorController@mineCollectList');
    Route::any('excavator/collect','ExcavatorController@collect');

    Route::get('excavator/visit/list/mine','ExcavatorController@mineVisitList');
    Route::any('excavator/visit','ExcavatorController@visit');
    Route::any('excavator/bid','ExcavatorController@bid');

    //绑定手机号
    Route::any('wechat/bind/phone','WechatController@bindPhone');
});

//公共路由
Route::group(['namespace'=>'Api'],function (){

    Route::any('wechat/login','WechatController@login');
    Route::post('auth/login','AuthController@login');
    //公共路由
    Route::any('region/city','RegionController@city');
    Route::any('banner/list', 'BannerController@index');
    Route::any('excavator/brand/list', 'BrandController@index');

    Route::any('rate','IndexController@rate');

});

