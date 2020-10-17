<?php


namespace App\Cache;

use App\Extend\ExchangeRate;

class ExchangeRateCache extends Cache
{



    public static function fetchList($fresh=false)
    {
        $key=__FUNCTION__.'v3';
        if($fresh){
            cache()->forget($key);
        }
        $ttl = 3600;
        return cache()->remember($key,$ttl,function (){
            return ExchangeRate::fetchList();
        });
    }

    public static function fetchJapan()
    {
        $list = self::fetchList();
        $japan = $list[5];
        return $japan[5];
    }
}