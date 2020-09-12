<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\SysRegionResource;
use App\Models\SysRegion;
use Illuminate\Http\Request;

/**
 * Class BannerController
 * @package App\Http\Controllers\Api\Backend
 */
class SysRegionController extends ApiController
{

    /**
     * @var SysRegion
     */
    protected $sysRegion;

    /**
     * RegionController constructor.
     * @param SysRegion $sysRegion
     */
    public function __construct(SysRegion $sysRegion)
    {
        $this->sysRegion = $sysRegion;
    }


    public function index(Request $request)
    {
        $paginate = $this->sysRegion->paginate($request->get('limit'));
        $data = SysRegionResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }


    public function topList(Request $request){

        $query = $this->sysRegion->topList();
        $parent_id = $request->get('parent_id',0);
        if($name = $request->get('name','')){
            $query->name("%$name%",'like');
        }else{
            $query->parentId($parent_id);
        }
        $paginate = $query->paginate($request->get('limit'));
        $data = SysRegionResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }

    public function tree(Request $request){

        $parent_id = $request->get('parent_id',0);
        $need_level = $request->get('need_level',0);
        $model_key = $this->sysRegion->getCacheKey();
        $key = sprintf("%s:%s:%s",$model_key,$parent_id,$need_level);
        $data = cache()->rememberForever($key,function ()use($parent_id,$need_level){
            $query = $this->sysRegion->query();
            if($need_level ){
                $query->where('level','<=',$need_level);
            }
            if($parent_id){
                $query->where('parent_id',$parent_id);
            }
            $all_region = $query->get()->toArray();
            return arr_to_tree_recursive($all_region,$parent_id);
        });
        return api_response()->success(['data'=>$data]);
    }

    public function create(Request $request)
    {
        $data = $this->validateRegion($request);
        $this->sysRegion->create($data);
        return api_response()->success();
   }

    public function detail(Request $request,int $id)
    {
        $model = $this->sysRegion->firstModelByIdOrFail($id);
        return api_response()->success(['data'=>$model]);
   }

    public function update(Request $request,int $id)
    {
        $model = $this->sysRegion->firstModelByIdOrFail($id);
        $model->setRawAttributes($this->validateRegion($request));
        $model->save();
        return api_response()->success();
   }

    public function delete(Request $request, int $id)
    {
        $model = $this->sysRegion->firstModelByIdOrFail($id);
        $model->delete();
        return api_response()->success();
   }


    public function batchDelete(Request $request)
    {
        $this->sysRegion->whereIn('id',$request->get('ids'))->delete();
        return api_response()->success();
   }

    protected function validateRegion(Request $request)
    {
         $data = $request->validate([
            'name'=>'required',
            'parent_id'=>'sometimes',
            'level'=>'sometimes',
            'pinyin'=>'sometimes',
            'short_name'=>'sometimes',
            'merger_name'=>'sometimes',
            'code'=>'sometimes',
            'zip_code'=>'sometimes',
            'first'=>'sometimes',
        ],[
            'name.required'=>'地区名称必须',
            'parent_id.required'=>'上级地区必须',
        ]);
        if($data['parent_id']==100000){
            $data['parent_id']=0;
        }
        return $data;
    }

}
