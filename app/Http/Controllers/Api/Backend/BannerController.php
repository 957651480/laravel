<?php


namespace App\Http\Controllers\Api\Backend;


use App\Http\Response\ApiResponse;
use App\Models\Banner;
use App\Services\FileService;
use Illuminate\Http\Request;

class BannerController extends BackendApiController
{

    public function index(Request $request)
    {
        $paginate = Banner::paginate($request->get('limit'));
        return api_response()->success(['data'=>$paginate->items()]);
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
