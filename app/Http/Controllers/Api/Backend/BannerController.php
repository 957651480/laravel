<?php


namespace App\Http\Controllers\Api\Backend;


use App\Http\Resources\Backend\BannerResource;
use App\Models\Banner;
use App\Services\BannerService;
use Illuminate\Http\Request;

/**
 * Class BannerController
 * @package App\Http\Controllers\Api\Backend
 */
class BannerController extends BackendApiController
{
    /**
     * @var BannerService
     */
    protected $service;

    /**
     * BannerController constructor.
     * @param BannerService $service
     */
    public function __construct(BannerService $service)
    {
        $this->service = $service;
    }


    public function index(Request $request)
    {
        $paginate = Banner::with('image')->paginate($request->get('limit'));
        $data = BannerResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }


    public function create(Request $request)
    {
        $data = $this->validateBanner($request);
        $this->service->create($data);
        return api_response()->success();
   }

    public function detail(Request $request,int $id)
    {
        $banner = $this->service->detail($id);
        return api_response()->success(['data'=>$banner]);
   }

    public function update(Request $request,int $id)
    {
        $banner = $this->service->firstModelByIdOrFail($id);
        $banner->setRawAttributes($this->validateBanner($request));
        $banner->save();
        return api_response()->success();
   }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return api_response()->success();
   }


    public function batchDelete(Request $request)
    {
        $this->service->batchDelete($request->get('ids'));
        return api_response()->success();
   }

    protected function validateBanner(Request $request)
    {
        return $request->validate([
            'title'=>'required',
            'image_id'=>'required',
            'show'=>'sometimes',
            'sort'=>'sometimes',
        ],[
            'title.required'=>'标题必须',
            'image_id.required'=>'图片必须',
        ]);
    }

}
