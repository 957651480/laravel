<?php


namespace App\Http\Controllers;


class ApiController extends Controller
{

    public function apiResponseError(int $code = 20000, string $msg = '成功', array $data = array())
    {
        return $this->apiResponse($code,$msg,$data);
    }

    public function apiResponseSuccess($code=20000,$msg='成功',$data=[])
    {
        return response()->json(compact('code','msg','data'));
    }
    public function apiResponse(int $code, string $msg , array $data)
    {
        return response()->json(compact('code','msg','data'));
    }
}
