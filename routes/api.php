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

    Route::any('category/list','CategoryController@index');
    Route::any('category/list/top','CategoryController@topList');
    Route::any('category/tree','CategoryController@tree');
    Route::any('category/create','CategoryController@create');
    Route::any('category/detail/{id}','CategoryController@detail');
    Route::any('category/update/{id}','CategoryController@update');
    Route::any('category/delete/{id}','CategoryController@delete');
    Route::any('category/batch/delete','CategoryController@batchDelete');
    Route::any('house/parking/identify','HouseController@identify');

    //地区
    Route::get('region/list', 'SysRegionController@index');
    Route::get('region/list/top', 'SysRegionController@topList');
    Route::get('region/tree', 'SysRegionController@tree');
    Route::post('region/create', 'SysRegionController@create');
    Route::get('region/detail/{id}', 'SysRegionController@detail');
    Route::post('region/update/{id}', 'SysRegionController@update');
    Route::get('region/delete/{id}', 'SysRegionController@delete');

});


Route::group(['middleware' => 'auth:api','namespace'=>'Api'], function ()
{


});

//公共路由
Route::group(['namespace'=>'Api'],function (){

    //公共路由
    Route::any('region/city','RegionController@city');
    Route::any('banner/list', 'BannerController@index');
    Route::any('brand/list', 'BrandController@index');

});

