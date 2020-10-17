<?php


namespace App\Extend;

use Http;

class ExchangeRate
{
    const EXCHANGE_RATE_API='http://web.juhe.cn:8080/finance/exchange/rmbquot?type=&bank=&key=f59b94e132e0ad10e03126d38ff027e7';

    public static function fetchList()
    {
        $response = Http::get(self::EXCHANGE_RATE_API)->json();
        if($response['error_code']!=0){
            throw new \Exception('汇率查询失败');
        }
        return $response['result'][0];
    }
}