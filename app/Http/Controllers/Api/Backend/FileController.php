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
        return api_response()->success(['total'=>$paginate->total(),'data'=>$paginate->items()]);
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
        $file->append('url');
        return api_response()->success(['data'=>$file]);

    }
}
