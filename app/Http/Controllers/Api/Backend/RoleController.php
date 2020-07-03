<?php


namespace App\Http\Controllers\Api\Backend;



class RoleController extends BackendApiController
{

    public function detail()
    {
        $data=[
            'roles'=>['admin']
        ];
        return response()->json($data);
    }
}
