<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Http\Resources\Api\MyVisitListResource;
use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends ApiController
{
    /**
     * @var Visit
     */
    protected $models;

    /**
     * VisitController constructor.
     * @param Visit $models
     */
    public function __construct(Visit $models)
    {
        $this->models = $models;
    }

    public function mineList(Request $request)
    {
        $user = $request->user();
        $paginate = $this->models->with(['excavator'])
            ->where('user_id',$user->id)->paginate($request->get('limit'));
        $data = MyVisitListResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }
}