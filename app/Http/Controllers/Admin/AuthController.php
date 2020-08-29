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
use App\Http\Resources\Admin\UserResource;
use App\Models\Ident;
use App\Models\User;
use Arr;
use Hash;
use Illuminate\Database\Eloquent\Collection;
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
        $user = $users->getUserByIdentifyPassword($username,$password);

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
