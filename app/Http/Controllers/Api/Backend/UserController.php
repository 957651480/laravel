<?php

namespace App\Http\Controllers\Api\Backend;


use Illuminate\Http\Request;

class UserController extends BackendApiController
{
    //
    public function login(Request $request)
    {
        return api_response()->success(['data'=>[
            'token'=>'jdskhdk'
        ]]);
    }

    public function info()
    {
        return api_response()->success(['data'=>[
            'roles'=>['admin']
        ]]);
    }
}
