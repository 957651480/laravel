<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Models\Ident;
use App\Models\User;
use Auth;
use Http;
use Illuminate\Http\Request;

class WechatController extends ApiController
{

    public function Login(Request $request,User $users)
    {
        list($code,$userInfo) = $this->ValidateLogin($request);

        $openId = app()->auth->session($code);

        if(!$user = $users->getUserByIdentify($openId))
        {
            $user = $users->createUser(['nickname'=>'微信用户'],['identify'=>$openId,'type'=>30]);
        }
        //登录
        Auth::loginUsingId($user->id);
        $token = $user->createToken('wechat-token');
        return api_response()->success(['data'=>['token'=>$token->plainTextToken]]);
    }


    public function ValidateLogin(Request $request)
    {
        $data = $this->validate($request,[
            'code' => 'required',
            'user_info' => 'required',
        ],[
            'code.required' => '授权码必须',
            'user_info' => '用户信息必须',
        ]);
        return [$data['code'],$data['user_info']];
    }
}