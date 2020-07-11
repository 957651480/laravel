<?php


namespace App\Http\Controllers\Api\Backend;


use App\Http\Response\ApiResponse;
use App\Models\Banner;
use App\Services\FileService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        $data = $this->validateCreateBanner($request);
        Banner::create($data);
        return api_response()->success();
   }

    public function detail(Request $request,int $id)
    {
        $banner = $this->firstBannerByIdOrFail($id);
        return api_response()->success(['data'=>$banner]);
   }

    public function update(Request $request,int $id)
    {
        $banner = $this->firstBannerByIdOrFail($id);
        $banner->setRawAttributes($request->all());
        return api_response()->success();
   }

    public function delete(Request $request, int $id)
    {
        $banner = $this->firstBannerByIdOrFail($id);
        $banner->delete();
        return api_response()->success();
   }

    /**
     * @param int $id
     * @return Banner|Banner[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    protected function firstBannerById(int $id)
    {
        return Banner::find($id);
   }

    /**
     * @param int $id
     * @return Banner|Banner[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     * @throws \Throwable
     */
    protected function firstBannerByIdOrFail(int $id)
    {
        $banner = $this->firstBannerById($id);
        throw_unless($banner,ModelNotFoundException::class);
        return $banner;
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
