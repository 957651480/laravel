<?php


namespace App\Cache;

class ExchangeRate extends Cache
{



    public static function fetchList($fresh=false)
    {
        $key=__FUNCTION__;
        if($fresh){
            cache()->forget($key);
        }
        return cache()->remember($key,10,function (){
            return ExchangeRate::fetchList();
        });
    }

    public static function fetchJapan()
    {
        $list = self::fetchList();
        return data_get($list,'japan');
    }
}