<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Models\Ident;
use App\Models\User;
use Arr;
use Auth;
use Hash;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
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
        Auth::loginUsingId($user_id);

        $token = $user->createToken('api-token');

        return api_response()->success(['data'=>['token'=>$token->plainTextToken]]);
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