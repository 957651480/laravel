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
        $paginate = $this->service->list([
            'limit'=>$request->get('limit'),
            'columns'=>['id','path']
        ]);
        $data =[
            'code'=>20000,
            'msg'=>'获取成功',
            'total'=>$paginate->total(),
            'data'=>$paginate->items()
        ];
        return response()->json($data);
    }


    public function upload(Request $request)
    {
        if (!$request->hasFile('file')) {
            //
        }
        if (!$request->file('file')->isValid()) {
            //
        }

        $file = $this->service->upload($request->file('file'));

        $data=[
            'code'=>20000,
            'data'=>$file
        ];
        return response()->json($data);

    }
}
