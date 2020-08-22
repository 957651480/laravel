<?php


namespace App\Http\Controllers\Admin;



use App\Http\Controllers\ApiController;

class RoleController extends ApiController
{

    public function detail()
    {
        $data=[
            'roles'=>['admin']
        ];
        return api_response()->success(['data'=>$data]);
    }
}
