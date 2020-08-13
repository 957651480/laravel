<?php


namespace App\Http\Controllers\Api\Backend;


use App\Http\Resources\Backend\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

/**
 * Class BannerController
 * @package App\Http\Controllers\Api\Backend
 */
class CategoryController extends BackendApiController
{

    /**
     * @var Category
     */
    protected $categories;

    /**
     * CategoryController constructor.
     * @param Category $categories
     */
    public function __construct(Category $categories)
    {
        $this->categories = $categories;
    }


    public function index(Request $request)
    {
        $paginate = $this->categories->paginate($request->get('limit'));
        $data = CategoryResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }


    public function topList(Request $request){

        $paginate = $this->categories->top()->paginate($request->get('limit'));
        $data = CategoryResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }

    public function tree($parent_id=0){

        $list = $this->categories->fetchAll();
        return api_response()->success(['data'=>List_to_tree_recursive($list)]);
    }

    public function create(Request $request)
    {
        $data = $this->validateCategory($request);
        $this->categories->create($data);
        return api_response()->success();
   }

    public function detail(Request $request,int $id)
    {
        $model = $this->categories->firstModelByIdOrFail($id);
        return api_response()->success(['data'=>$model]);
   }

    public function update(Request $request,int $id)
    {
        $model = $this->categories->firstModelByIdOrFail($id);
        $model->setRawAttributes($this->validateCategory($request));
        $model->save();
        return api_response()->success();
   }

    public function delete(Request $request, int $id)
    {
        $model = $this->categories->firstModelByIdOrFail($id);
        $model->delete();
        return api_response()->success();
   }


    public function batchDelete(Request $request)
    {
        $this->categories->whereIn('id',$request->get('ids'))->delete();
        return api_response()->success();
   }

    protected function validateCategory(Request $request)
    {
        return $request->validate([
            'name'=>'required',
            'seo_title'=>'sometimes',
            'seo_keyword'=>'sometimes',
            'seo_description'=>'sometimes',
            'show'=>'sometimes',
            //'sort'=>'sometimes',
        ],[
            'title.required'=>'名称必须',
        ]);
    }

}
