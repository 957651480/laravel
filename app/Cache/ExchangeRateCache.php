<?php


namespace App\Cache;

class ExchangeRate extends Cache
{


    /**
     *
     */
    public static function fetchList()
    {
        $list = cache()->remember(__FUNCTION__,10,function (){
            return ExchangeRate::fetchList();
        });
        return $list;
    }

    public static function fetchJapan()
    {
        $list = self::fetchList();
        return data_get($list,'japan');
    }
}