<?php
/**
 * File AuthController.php
 *
 * @author Tuan Duong <bacduong@gmail.com>
 * @package Laravue
 * @version 1.0
 */
namespace App\Http\Controllers\Api\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\UserResource;
use App\Models\Ident;
use App\Models\User;
use Arr;
use Hash;
use Illuminate\Http\Request;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        list($username,$password) = $this->validateLogin($request);

        $user_id = Ident::getUidByIdentify($username);

        if(!$user = User::find($user_id)){
            return api_response()->fail(['msg'=>'用户账号或密码有误']);
        }
        if(!Hash::check($password,$user->password)){
            return api_response()->fail(['msg'=>'用户账号或密码有误']);
        }
        \Auth::loginUsingId($user_id);

        //todo
        $user->token = 'hjkdskhfjdls';
        $user = new UserResource($user);
        return api_response()->success(['data'=>new UserResource($user)]);
    }

    public function logout(Request $request)
    {
        //$request->user()->tokens()->delete();
        //todo
        return api_response()->success();
    }

    public function user(Request $request)
    {
        $user = $request->user();
        return api_response()->success(['data'=>new UserResource($user)]);
    }

    public function wxLogin(Request $request)
    {
        $form = $request->all();
        $rules=[
            'code'=>'required',
            'user_info'=>'required',
        ];
        $validator = \Validator::make($form,$rules,[
            'code.required'=>'授权码必须',
            'user_info'=>'用户信息必须',
        ]);
        if($validator->fails()){
            return api_response()->fail(['msg'=>$validator->messages()->first()]);
        }

        $code = Arr::get($form,'code');
        $wechat = config('wechat');
        $session = $this->sessionKey($code,$wechat['app_id'],$wechat['secret']);
        if (isset($session['errcode']))
        {
            return api_response()->fail(['msg'=>$session['errmsg']]);
        }
        // 自动注册用户
        $refereeId = isset($form['referee_id']) ? $form['referee_id'] : null;
        $userInfo = json_decode($form['user_info'], true);
        //查询openId
        $openid = Arr::get($session,'openid');
        $userData = Arr::only($userInfo,['nickName','avatarUrl']);
        $users = new User();
        if(!$user = $users->where('open_id',$openid)->first())
        {
            $user = new User();
            $user->open_id = $openid;
            $user->username = $openid;
            $user->nickName = $userData['nickName'];
            $user->avatarUrl = $userData['avatarUrl'];
            $user->save();
        }
        //登录
        Auth::loginUsingId($user->id);
        $user = $request->user();
        //todo
        $token = 'dsfds';
        $user->token = $token->plainTextToken;
        return api_response()->success(['data'=>new UserResource($user)]);
    }


    /**
     * @param Request $request
     * @return array
     */
    protected function validateLogin(Request $request)
    {
         $data = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
         return [$data['username'],$data['password']];
    }
}
