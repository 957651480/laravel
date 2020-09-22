<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\UserResource;
use App\Http\Resources\Admin\WeChatListResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserController extends ApiController
{

    public function weChatList(Request $request)
    {
        $param=array_merge([
            'nickname'=>''
        ],$request->all());
        $query = User::query();
        $nickname = data_get($param,'nickname');
        $query->when($nickname,function (Builder $query,$nickname){
            $query->where('nickname','like',"%{$nickname}%");
        });

        $query->whereHas('indents',function (Builder $query){
           $query->where('type','openid');
        });
        $paginate = $query->with(['indents'])->paginate($request->get('limit'));
        $data = WeChatListResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }

    public function info(Request $request)
    {
        $user = $request->user();
        return api_response()->success(['data'=>new UserResource($user)]);
    }
}
