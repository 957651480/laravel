<?php

use Faker\Generator as Faker;
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
Route::group(['prefix'=>'admin/','namespace'=>'Admin'],function ()
{
    Route::post('auth/login','AuthController@login');

});
//后台api
Route::group(['prefix'=>'admin/','namespace'=>'Admin','middleware' => 'auth:sanctum'],function()
{
    Route::get('auth/logout','AuthController@logout');
    Route::get('user/info','UserController@info');

    //轮播图
    Route::get('banner', 'BannerController@index');
    Route::post('banner/create', 'BannerController@store');
    Route::get('banner/detail/{id}', 'BannerController@show');
    Route::post('banner/update/{id}', 'BannerController@update');
    Route::get('banner/delete/{id}', 'BannerController@destroy');
    Route::post('banner/batch/delete','BannerController@batchDelete');

    //品牌
    Route::get('brand', 'BrandController@index');
    Route::post('brand/create', 'BrandController@store');
    Route::get('brand/detail/{id}', 'BrandController@show');
    Route::post('brand/update/{id}', 'BrandController@update');
    Route::get('brand/delete/{id}', 'BrandController@destroy');
    Route::post('brand/batch/delete','BrandController@batchDelete');

});


Route::group(['middleware' => 'auth:api','namespace'=>'Api'], function ()
{
    Route::get('file/list','FileController@index');
    Route::post('file/upload','FileController@upload');

    Route::any('banner/list','BannerController@index');
    Route::any('banner/create','BannerController@create');
    Route::any('banner/detail/{id}','BannerController@detail');
    Route::any('banner/update/{id}','BannerController@update');
    Route::any('banner/delete/{id}','BannerController@delete');
    Route::any('banner/batch/delete','BannerController@batchDelete');

    Route::any('category/list','CategoryController@index');
    Route::any('category/list/top','CategoryController@topList');
    Route::any('category/tree','CategoryController@tree');
    Route::any('category/create','CategoryController@create');
    Route::any('category/detail/{id}','CategoryController@detail');
    Route::any('category/update/{id}','CategoryController@update');
    Route::any('category/delete/{id}','CategoryController@delete');
    Route::any('category/batch/delete','CategoryController@batchDelete');
    Route::any('house/parking/identify','HouseController@identify');
    Route::any('auction/create', 'AuctionController@auction');
});

//公共路由
Route::group(['namespace'=>'Api'],function (){

    //公共路由
    Route::any('region/city','RegionController@city');
    Route::any('banner/list', 'BannerController@index');
    Route::any('brand/list', 'BrandController@index');

});

