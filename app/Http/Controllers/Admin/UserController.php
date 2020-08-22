<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\UserResource;
use Illuminate\Http\Request;

class UserController extends ApiController
{

    public function info(Request $request)
    {
        $user = $request->user();
        return api_response()->success(['data'=>new UserResource($user)]);
    }
}
