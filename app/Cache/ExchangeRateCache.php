<?php


namespace App\Cache;

use App\Extend\ExchangeRate;
use Illuminate\Support\Carbon;

class ExchangeRateCache extends Cache
{



    public static function fetchList($fresh=false)
    {
        $key=__FUNCTION__;
        if($fresh){
            cache()->forget($key);
        }
        $ttl = Carbon::now()->endOfDay();
        return cache()->remember($key,$ttl,function (){
            return ExchangeRate::fetchList();
        });
    }

    public static function fetchJapan()
    {
        $list = self::fetchList();
        $japan = $list[5];
        return 100/$japan[2];
    }
}