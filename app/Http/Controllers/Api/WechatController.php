<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class WechatController extends ApiController
{
    const WECHAT_TOKEN='Wechat-token';

    public function Login(Request $request,User $users)
    {
        list($code,$userInfo) = $this->validateLogin($request);

        $openId = app()->auth->session($code);

        if(!$user = $users->getUserByIdentify($openId))
        {
            $user = $users->createUser(['nickname'=>'微信用户'],['identify'=>$openId,'type'=>30]);
        }
        //登录
        Auth::loginUsingId($user->id);
        $token = $user->createToken(self::WECHAT_TOKEN);
        return api_response()->success(['data'=>['token'=>$token->plainTextToken]]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return api_response()->success();
    }

    /**
     * @param Request $request
     * @return array
     * @throws @\Illuminate\Validation\ValidationException
     */
    public function validateLogin(Request $request)
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