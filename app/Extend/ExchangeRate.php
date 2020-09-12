<?php


namespace App\Extend;

use Http;

class ExchangeRate
{
    const EXCHANGE_RATE_API='http://op.juhe.cn/onebox/exchange/query?key=15e0036283e68cce6bee4847631d39ce';

    public static function fetchList()
    {
        $response = Http::get(self::EXCHANGE_RATE_API)->json();
        if($response['error_code']!=0){
            throw new \Exception('汇率查询失败');
        }
        return $response['result']['list'];
    }
}