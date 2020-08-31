<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\BannerResource;
use App\Models\Banner;
use Illuminate\Http\Request;

/**
 * Class BannerController
 * @package App\Http\Controllers\Api\Backend
 */
class IndexController extends ApiController
{


    public function index(Request $request,Banner $banner)
    {
        $paginate = $this->banners->with('image')->paginate($request->get('limit'));
        $data = BannerResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }

}
