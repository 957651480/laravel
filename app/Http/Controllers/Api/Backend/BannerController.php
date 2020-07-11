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


    public function create(Request $request)
    {
        Banner::create($request->all());
   }


    protected function validateBanner($form)
    {
        $validator = validator($form);
        if($validator->fails()){
            return api_response()->fail(['msg'=>$validator->messages()->first()]);
        }
        return $validator->validated();
   }
}
