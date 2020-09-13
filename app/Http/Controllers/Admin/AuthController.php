<?php
/**
 * File AuthController.php
 *
 * @author Tuan Duong <bacduong@gmail.com>
 * @package Laravue
 * @version 1.0
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    const ADMIN_TOKEN='Admin-token';

    /**
     * @param Request $request
     * @param User $users
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request,User $users)
    {
        list($username,$password) = $this->validateLogin($request);
        if(!$user = $users->getUserByIdentifyPassword($username,$password)){
            return  api_response()->fail(['msg'=>'用户未注册']);
        }
        if(!Hash::check($password,$user->password)){
            return  api_response()->fail(['msg'=>'用户账号或密码有误']);
        }
        \Auth::loginUsingId($user->id);

        $token = $user->createToken(self::ADMIN_TOKEN);

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
