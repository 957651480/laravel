<?php


namespace App\Http\Controllers\Api\Backend;


use App\Http\Resources\Backend\BannerResource;
use App\Models\Banner;
use App\Models\Category;
use App\Services\BannerService;
use Illuminate\Http\Request;

/**
 * Class BannerController
 * @package App\Http\Controllers\Api\Backend
 */
class CategoryController extends BackendApiController
{



    public function index(Request $request)
    {
        $paginate = Category::paginate($request->get('limit'));
        $data = BannerResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }


    public function topList(Request $request){

        $paginate = Category::paginate($request->get('limit'));
        $data = BannerResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }
    public function create(Request $request)
    {
        $data = $this->validateCategory($request);
        Category::create($data);
        return api_response()->success();
   }

    public function detail(Request $request,int $id)
    {
        $model = Category::firstModelByIdOrFail($id);
        return api_response()->success(['data'=>$model]);
   }

    public function update(Request $request,int $id)
    {
        $model = Category::firstModelByIdOrFail($id);
        $model->setRawAttributes($this->validateCategory($request));
        $model->save();
        return api_response()->success();
   }

    public function delete(Request $request, int $id)
    {
        $model = Category::firstModelByIdOrFail($id);
        $model->delete();
        return api_response()->success();
   }


    public function batchDelete(Request $request)
    {
        Category::whereIn('id',$request->get('ids'))->delete();
        return api_response()->success();
   }

    protected function validateCategory(Request $request)
    {
        return $request->validate([
            'title'=>'required',
            'seo_title'=>'sometimes',
            'seo_keyword'=>'sometimes',
            'seo_description'=>'sometimes',
            'show'=>'sometimes',
            'sort'=>'sometimes',
        ],[
            'title.required'=>'标题必须',
        ]);
    }

}
