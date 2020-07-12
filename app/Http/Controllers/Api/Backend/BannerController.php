<?php


namespace App\Http\Controllers\Api\Backend;


use App\Http\Response\ApiResponse;
use App\Models\Banner;
use App\Services\BannerService;
use App\Services\FileService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        $paginate = Banner::paginate($request->get('limit'));
        return api_response()->success(['total'=>$paginate->total(),'data'=>$paginate->items()]);
    }


    public function create(Request $request)
    {
        $data = $this->validateCreateBanner($request);
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
        $banner->setRawAttributes($request->all());
        return api_response()->success();
   }

    public function delete(Request $request, int $id)
    {
        $banner = $this->service->delete($id);
        return api_response()->success();
   }



    protected function validateCreateBanner(Request $request)
    {
        return $request->validate([
            'title'=>'required'
        ],[
            'title.required'=>'标题必须'
        ]);
   }
}
