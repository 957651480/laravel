<?php


namespace App\Cache;

use App\Extend\ExchangeRate;
use Illuminate\Support\Carbon;

class ExchangeRateCache extends Cache
{



    public static function fetchList($fresh=false)
    {
        $key=__FUNCTION__.'v3';
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
        //var_dump(json_encode($list));die();
        $japan = $list['data4'];
        return number_format(100/$japan['bankConversionPri'],2);
    }
}