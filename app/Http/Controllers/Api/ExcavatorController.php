<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\ExcavatorResource;
use App\Http\Resources\Api\MyCollectListResource;
use App\Http\Resources\Api\MyVisitListResource;
use App\Models\Bid;
use App\Models\Collect;
use App\Models\Excavator;
use App\Models\Visit;
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
        $paginate = Excavator::with(['images','video'])->paginate($request->get('limit'));
        $data = ExcavatorResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }


    public function detail(Request $request,int $id)
    {
        $model = $this->excavators->firstModelByIdOrFail($id,['images','video']);
        $data = new ExcavatorResource($model);
        return api_response()->success(['data'=>$data]);
   }

    public function mineVisitList(Request $request)
    {
        $user = $request->user();
        $paginate = $this->models->with(['excavator'])
            ->where('user_id',$user->id)->paginate($request->get('limit'));
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
        $paginate = $this->models->with(['excavator'])
            ->where('user_id',$user->id)->paginate($request->get('limit'));
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

    public function bid(Request $request)
    {
        $user = $request->user();
        if(!$excavator_id = $request->get('excavator_id')){
            return api_response()->fail(['msg'=>'请选择的挖机']);
        }
        $price = $request->get('price');
        if($price<0){
            return api_response()->fail(['msg'=>'价格必须大于0']);
        }
        Bid::updateOrCreate([
            'user_id'=>$user->id,
            'excavator_id'=>$excavator_id
        ],['price'=>$price]);
        return api_response()->success(['msg'=>'报价成功']);
    }
}
