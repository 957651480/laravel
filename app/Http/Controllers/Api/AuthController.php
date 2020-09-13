<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Models\User;
use Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
    public function login(Request $request,User $users)
    {
        list($username,$password) = $this->validateLogin($request);

        $user = $users->getUserByIdentifyPassword($username,$password);

        Auth::loginUsingId($user->id);
        /**
         * @var $Kk Collection
         */
        $Kk = $user->indentTypeAndIdentify->pluck('identify','type');
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