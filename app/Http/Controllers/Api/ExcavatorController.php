<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Http\Resources\Api\ExcavatorDetailResource;
use App\Http\Resources\Api\ExcavatorListResource;
use App\Http\Resources\Api\MyCollectListResource;
use App\Http\Resources\Api\MyReserveListResource;
use App\Http\Resources\Api\MyVisitListResource;
use App\Models\Collect;
use App\Models\Excavator;
use App\Models\Reserve;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;


class ExcavatorController extends ApiController
{
    
    protected $excavators;

    
    public function __construct(Excavator $excavators)
    {
        $this->excavators = $excavators;
    }


    public function index(Request $request)
    {
        $param=array_merge([
            'page'=>1,
            'limit'=>15,
            'brand_id'=>'',
            'weight_start'=>'',
            'weight_end'=>'',
            'recommend'=>'',
        ],$request->all());

        $brand_id = (integer)data_get($param,'brand_id');
        $recommend = (integer)data_get($param,'recommend');
        $weight_start = (integer)data_get($param,'weight_start');
        $weight_end = (integer)data_get($param,'weight_end');
        $query = Excavator::query();
        $query->when($brand_id,function (Builder $query,$brand_id){
            $query->where('brand_id',$brand_id);
        });
        $query->when($recommend,function (Builder $query,$recommend){
            $query->where('recommend',$recommend);
        });
        if($weight_start&&$weight_end){
            $query->whereBetween('weight',[$weight_start,$weight_end]);
        }elseif ($weight_start){
            $query->where('weight','>',$weight_start);
        }elseif ($weight_end){
            $query->where('weight','<',$weight_end);
        }

        $paginate = $query->with(['images','video','region','brand'])
            ->paginate($request->get('limit'));
        $data = ExcavatorListResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }

    public function detail(Request $request,$id)
    {
        $model = $this->excavators->firstModelByIdOrFail($id,['images','video','brand']);
        $data = new ExcavatorDetailResource($model);
        return api_response()->success(['data'=>$data]);
    }
    public function mineVisitList(Request $request)
    {
        $user = $request->user();
        $query = Visit::query();
        $query->where('user_id',$user->id);

        $paginate = $query->with(['excavator.images','excavator.video','excavator.region','excavator.brand','user'])
            ->paginate($request->get('limit'));
        $data = MyVisitListResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }

    public function visit(Request $request)
    {
        $user = $request->user();
        if(!$excavator_id = $request->get('excavator_id')){
            return api_response()->fail(['msg'=>'请选择的挖机']);
        }
        Visit::create([
            'user_id'=>$user->id,
            'excavator_id'=>$excavator_id
        ]);
        return api_response()->success(['msg'=>'成功']);
    }

    public function mineCollectList(Request $request)
    {
        $user = $request->user();
        $query = Collect::query();
        $query->where('user_id',$user->id);

        $paginate = $query->with(['excavator.images','excavator.video','excavator.region','excavator.brand','user'])
            ->paginate($request->get('limit'));
        $data = MyCollectListResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }

    public function collect(Request $request)
    {
        $user = $request->user();
        if(!$excavator_id = $request->get('excavator_id')){
            return api_response()->fail(['msg'=>'请选择收藏的挖机']);
        }
        Collect::create([
            'user_id'=>$user->id,
            'excavator_id'=>$excavator_id
        ]);
        return api_response()->success();
    }


    public function mineReserveList(Request $request)
    {
        $user = $request->user();
        $sub_query = Reserve::select(['excavator_id'])
            ->where('user_id',$user->id);
        $paginate = $this->excavators->with(['images','video','region','brand'])
            ->rightJoinSub($sub_query,'c','c.excavator_id','=','id')
            ->paginate($request->get('limit'));
        $data = MyReserveListResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }

    public function reserve(Request $request)
    {
        $user = $request->user();
        if(!$excavator_id = $request->get('excavator_id')){
            return api_response()->fail(['msg'=>'请选择的挖机']);
        }
        $price = $request->get('price');
        if($price<0){
            return api_response()->fail(['msg'=>'价格必须大于0']);
        }
        Reserve::updateOrCreate([
            'user_id'=>$user->id,
            'excavator_id'=>$excavator_id
        ],['price'=>$price]);
        return api_response()->success(['msg'=>'报价成功']);
    }
}
