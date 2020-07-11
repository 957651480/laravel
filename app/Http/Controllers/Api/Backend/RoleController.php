<?php


namespace App\Http\Controllers\Api\Backend;



class RoleController extends BackendApiController
{

    public function detail()
    {
        $data=[
            'roles'=>['admin']
        ];
        return api_response()->success(['data'=>$data]);
    }
}
