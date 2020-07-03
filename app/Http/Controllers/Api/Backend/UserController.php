<?php

namespace App\Http\Controllers\Api\Backend;


use Illuminate\Http\Request;

class UserController extends BackendApiController
{
    //
    public function login(Request $request)
    {
        $data =[
          'code'=>20000,
          'data'=>[
              'token'=>'sdsds'
          ]
        ];
        return response()->json($data);
    }

    public function info()
    {

        $data=[
            'code'=>20000,
            'data'=>[
                'roles'=>['admin']
            ]
        ];
        return response()->json($data);
    }
}
