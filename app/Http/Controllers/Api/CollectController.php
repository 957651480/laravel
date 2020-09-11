<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Http\Resources\Api\MyCollectListResource;
use App\Models\Collect;
use Illuminate\Http\Request;

class CollectController extends ApiController
{
    /**
     * @var Collect
     */
    protected $models;

    /**
     * CollectController constructor.
     * @param Collect $models
     */
    public function __construct(Collect $models)
    {
        $this->models = $models;
    }

    public function mineList(Request $request)
    {
        $user = $request->user();
        $paginate = $this->models->with(['excavator'])
            ->where('user_id',$user->id)->paginate($request->get('limit'));
        $data = MyCollectListResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }

    public function create(Request $request)
    {
        $user = $request->user();
        if(!$excavator_id = $request->get('excavator_id')){
            return api_response()->json(['msg'=>'请选择收藏的挖机']);
        }
        $this->models->create([
            'user_id'=>$user->id,
            'excavator_id'=>$excavator_id
        ]);
        return api_response()->success();
    }
}