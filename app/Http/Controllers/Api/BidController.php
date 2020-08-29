<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Http\Resources\Api\MyBidListResource;
use App\Models\Bid;
use Illuminate\Http\Request;

class BidController extends ApiController
{
    /**
     * @var Bid
     */
    protected $models;

    /**
     * BidController constructor.
     * @param Bid $models
     */
    public function __construct(Bid $models)
    {
        $this->models = $models;
    }

    public function mineList(Request $request)
    {
        $user = $request->user();
        $paginate = $this->models->with(['excavator'])
            ->where('user_id',$user->id)->paginate($request->get('limit'));
        $data = MyBidListResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }
}