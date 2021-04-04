<?php


namespace App\Library;


use Illuminate\Support\Arr;

class ApiResponse extends \Illuminate\Http\JsonResponse
{

    const MAP=[
        0=>'成功',
        1=>'失败',
    ];
    public function __construct($data = null, $status = 200, $headers = [], $options = 0)
    {
        parent::__construct($data, $status, $headers, $options);
    }

    public function success($data=[],$code =0,$msg='')
    {
        $this->setData(array_merge($data,[
            'code'=>$code,
            'msg'=>$msg?:Arr::get(self::MAP,$code,'成功'),
        ]));
        return $this;
    }

    public function fail($msg = '',$code =1,$data=[])
    {
        $this->setData(array_merge($data,[
            'code'=>$code,
            'msg'=>$msg?:Arr::get(self::MAP,$code,'失败'),
        ]));
        return $this;
    }

    public function antiSuccess($data=[],$code =0,$msg='')
    {
        return $this->success(array_merge($data,['success'=>true]),$code,$msg);
    }

    public function antiFail($data=[],$code =1,$msg='')
    {
        return $this->fail(array_merge($data,['success'=>false]),$code,$msg);
    }
}