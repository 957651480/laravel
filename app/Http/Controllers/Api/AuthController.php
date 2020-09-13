<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
    public function login(Request $request,User $users)
    {
        list($username,$password) = $this->validateLogin($request);

        if(!$user = $users->getUserByIdentifyPassword($username,$password)){
            return  api_response()->fail(['msg'=>'用户未注册']);
        }
        if(!Hash::check($password,$user->password)){
            return  api_response()->fail(['msg'=>'用户账号或密码有误']);
        }
        Auth::loginUsingId($user->id);

        $token = $user->createToken('api-token');

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