<?php


namespace App\Extend;

use Http;

class ExchangeRate
{
    const EXCHANGE_RATE_API='http://op.juhe.cn/onebox/exchange/query?&key=b42a4619055788cb98496ce3173aa472';

    public static function fetchList()
    {
        $response = Http::get(self::EXCHANGE_RATE_API)->json();
        $list = $response['result']['list']??[];
        if(!$list){
            throw new \Exception('汇率查询失败');
        }
        return $list;
    }
}