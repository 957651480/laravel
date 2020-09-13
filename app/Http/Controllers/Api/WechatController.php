<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class WechatController extends ApiController
{
    const WECHAT_TOKEN='Wechat-token';


    public function Login(Request $request,User $users)
    {
        list($code,$userInfo,$encrypted_data,$encrypt_iv) = $this->validateLogin($request);
        $miniProgram = \EasyWeChat::miniProgram();
        $session = $miniProgram->auth->session($code);
        if(isset($session['errcode'])){
            throw new \Exception($session['errmsg']);
        }
        $openId = $session['openid'];
        if(!$user = $users->getUserByIdentify($openId))
        {
            $user = $users->createUser([
                'nickname'=>$userInfo['nickName'],
                'avatar'=>$userInfo['avatarUrl']
            ],['identify'=>$openId,'type'=>'openid']);

            //解密手机号
            if($encrypt_iv&&$encrypted_data){
                try {
                    //todo
                    $Kk = $miniProgram->encryptor->decryptData($session['session_key'],$encrypt_iv,$encrypted_data);
                }catch (\Exception $exception){

                }
            }
        }
        //登录
        Auth::loginUsingId($user->id);
        $token = $user->createToken(self::WECHAT_TOKEN);
        $user->token = $token->plainTextToken;
        $user->session_key = $session['session_key'];
        return api_response()->success(['data'=>new UserResource($user)]);
    }

    public function bindPhone(Request $request)
    {
        list($code,$encrypted_data,$encrypt_iv) = $this->validateBind($request);
        $miniProgram = \EasyWeChat::miniProgram();
        $session = $miniProgram->auth->session($code);
        if(isset($session['errcode'])){
            throw new \Exception($session['errmsg']);
        }
        try {
            $data= $miniProgram->encryptor->decryptData($session['session_key'],$encrypt_iv,$encrypted_data);
            $phone = $data['phoneNumber'];
            $user = $request->user();
            $user->indents()->create([
                'identify'=>$phone,
                'type'=>'phone'
            ]);
            return api_response()->success(['data'=>['phone'=>$phone],'msg'=>'绑定成功']);
        }catch (\Exception $exception){
            logger('手机绑定异常',['exception'=>$exception]);
            return api_response()->fail(['msg'=>'绑定失败']);
        }
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
    public function validateBind(Request $request)
    {
        $data = $this->validate($request,[
            'code' => 'required',
            'encrypted_data' => 'sometimes',
            'encrypt_iv' => 'sometimes',
        ],[
            'code.required' => '授权码必须',
        ]);
        $encrypted_data = data_get($data,'encrypted_data');
        $encrypt_iv = data_get($data,'encrypt_iv');
        return [$data['code'],$encrypted_data,$encrypt_iv];
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
            'userInfo' => 'required',
            'encrypted_data' => 'sometimes',
            'encrypt_iv' => 'sometimes',
        ],[
            'code.required' => '授权码必须',
            'userInfo' => '用户信息必须',
        ]);
        $encrypted_data = data_get($data,'encrypted_data');
        $encrypt_iv = data_get($data,'encrypt_iv');
        return [$data['code'],$data['userInfo'],$encrypted_data,$encrypt_iv];
    }
}