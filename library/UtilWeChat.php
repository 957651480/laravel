<?php

namespace Lib;

class UtilWeChat
{

    public static function session($code)
    {
        $miniProgram = \EasyWeChat::miniProgram();
        return self::formatResponse($miniProgram->auth->session($code));
    }


    public static function formatResponse($result)
    {
        if(isset($result['errcode'])){
            logger('wechat error',$result);
            throw new \Exception($result['errmsg']);
        }
        return $result;
    }
}