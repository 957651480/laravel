<?php


namespace App\Http\Response;


use Illuminate\Contracts\Routing\ResponseFactory;


class ApiResponse
{
    /**
     * @var ResponseFactory
     */
    protected $response;

    /**
     * @var int
     */
    protected $code;

    /**
     * @var string
     */
    protected  $msg;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * ApiResponse constructor.
     * @param int $code
     * @param string $msg
     * @param mixed $data
     */
    public function __construct(int $code=20000, string $msg='成功', $data=[])
    {
        $this->response=response();
        $this->code = $code;
        $this->msg = $msg;
        $this->data = $data;
    }

    /**
     * @return ResponseFactory
     */
    public function getResponse(): ResponseFactory
    {
        return $this->response;
    }

    /**
     * @param ResponseFactory $response
     * @return ApiResponse
     */
    public function setResponse(ResponseFactory $response): ApiResponse
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     * @return ApiResponse
     */
    public function setCode(int $code): ApiResponse
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg;
    }

    /**
     * @param string $msg
     * @return ApiResponse
     */
    public function setMsg(string $msg): ApiResponse
    {
        $this->msg = $msg;
        return $this;
    }

    /**
     * @return array|mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed|array $data
     * @return $this
     */
    public function setData($data): ApiResponse
    {
        $this->data = $data;
        return $this;
    }

    public function success($response=array())
    {
        $response = $this->dataFill($response);
        return $this->response->json($response);
    }

    public function fail($response)
    {
        $response = $this->dataFill($response,false);
        return $this->response->json($response);
    }

    /**
     * @param $response
     * @return \Illuminate\Http\JsonResponse
     */
    public function json($response)
    {
        $response = $this->dataFill($response,data_get($response,'code'));
        return $this->response->json($response);
    }

    public function dataFill($response,$result=true)
    {
        data_fill($response,'code',$result?20000:0);
        data_fill($response,'msg',$result?'成功':'失败');
        data_fill($response,'data',array());
        return $response;
    }
}
