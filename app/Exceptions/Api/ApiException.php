<?php

namespace App\Exceptions\Api;

use Exception;

class ApiException extends Exception
{
    //
    public function render()
    {
        return api_response()->fail(['msg'=>$this->message]);
    }
}
