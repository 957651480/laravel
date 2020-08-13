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
Route::namespace('Api')->group(function (){

    //后台api
    Route::prefix('admin/')->namespace('Backend')->group(function(){

        Route::post('user/login','UserController@login');
        Route::get('user/logout','UserController@logout');
        Route::get('user/info','UserController@info');

        Route::get('/article/list', function (Faker $faker) {
            $rowsNumber = 10;
            $list = [];
            for ($rowIndex = 0; $rowIndex < $rowsNumber; $rowIndex++) {
                $row = [
                    'id' => mt_rand(100, 10000),

                    'display_time' => $faker->dateTime()->format('Y-m-d H:i:s'),
                    'title' => Str::random(),
                    'author' => Str::random(5),
                    'comment_disabled' => boolval(mt_rand(0,1)),
                    'content' => Str::random(100),
                    'content_short' => Str::random(50),
                    'status' => Arr::random(['deleted', 'published', 'draft']),
                    'forecast' => mt_rand(100, 9999) / 100,
                    'image_uri' => 'https://via.placeholder.com/400x300',
                    'importance' => mt_rand(1, 3),
                    'pageviews' => mt_rand(10000, 999999),
                    'reviewer' => Str::random(5),
                    'timestamp' => $faker->dateTime()->getTimestamp(),
                    'type' => Arr::random(['US', 'VI', 'JA']),

                ];

                $list[] = $row;
            }
            $data =[
                'code'=>20000,
                'data'=>[
                    'items'=>$list,
                    'total'=>count($list)
                ]
            ];
            return response()->json($data);
        });

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
    });
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
