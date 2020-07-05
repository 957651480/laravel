<?php


namespace App\Http\Controllers\Api\Backend;


use App\Services\FileService;
use Illuminate\Http\Request;

class FileController extends BackendApiController
{

    /**
     * @var FileService
     */
    protected $service;

    /**
     * FileController constructor.
     * @param FileService $service
     */
    public function __construct(FileService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $list = $this->service->list();
        $data =[
            'code'=>20000,
            'msg'=>'获取成功',
            'data'=>[]
        ];
        return response()->json($data);
    }
}
