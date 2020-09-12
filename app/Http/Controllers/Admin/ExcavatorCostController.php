<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\ExcavatorCostResource;
use App\Models\ExcavatorCost;
use Illuminate\Http\Request;

/**
 * Class BannerController
 * @package App\Http\Controllers\Api\Backend
 */
class ExcavatorCostController extends ApiController
{

    /**
     * @var ExcavatorCost
     */
    protected $excavatorCosts;

    /**
     * ExcavatorCostController constructor.
     * @param ExcavatorCost $excavatorCosts
     */
    public function __construct(ExcavatorCost $excavatorCosts)
    {
        $this->excavatorCosts = $excavatorCosts;
    }


    public function index(Request $request)
    {
        $paginate = $this->excavatorCosts->paginate($request->get('limit'));
        $data = ExcavatorCostResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }


    public function topList(Request $request){

        $paginate = $this->excavatorCosts->top()->paginate($request->get('limit'));
        $data = ExcavatorCostResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }

    public function tree($parent_id=0){

        $list = $this->excavatorCosts->fetchAll();
        $data=arr_to_tree_recursive($list,$parent_id);
        //深度递归

        return api_response()->success(['data'=>$data]);
    }

    public function create(Request $request)
    {
        $data = $this->validateExcavatorCost($request);
        $this->excavatorCosts->create($data);
        return api_response()->success();
   }

    public function detail(Request $request,int $id)
    {
        $model = $this->excavatorCosts->firstModelByIdOrFail($id);
        return api_response()->success(['data'=>$model]);
   }

    public function update(Request $request,int $id)
    {
        $model = $this->excavatorCosts->firstModelByIdOrFail($id);
        $model->setRawAttributes($this->validateExcavatorCost($request));
        $model->save();
        return api_response()->success();
   }

    public function delete(Request $request, int $id)
    {
        $model = $this->excavatorCosts->firstModelByIdOrFail($id);
        $model->delete();
        return api_response()->success();
   }


    public function batchDelete(Request $request)
    {
        $this->excavatorCosts->whereIn('id',$request->get('ids'))->delete();
        return api_response()->success();
   }

    protected function validateExcavatorCost(Request $request)
    {
        return $request->validate([
            'name'=>'required',
            'parent_id'=>'sometimes',
        ],[
            'title.required'=>'名称必须',
        ]);
    }

}
