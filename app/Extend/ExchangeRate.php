<?php


namespace App\Extend;

use Http;

class ExchangeRate
{
    const EXCHANGE_RATE_API='';

    public static function fetchList()
    {
        $response = Http::get(self::EXCHANGE_RATE_API);
        return $response->json();
    }
}