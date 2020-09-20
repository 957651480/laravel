<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\CollectListResource;
use App\Http\Resources\Admin\OrderListResource;
use App\Http\Resources\Admin\VisitListResource;
use App\Models\Collect;
use App\Models\Order;
use App\Models\Visit;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;


class OrderController extends ApiController
{
    
    protected $orders;

    
    public function __construct(Order $orders)
    {
        $this->orders = $orders;
    }


    public function index(Request $request)
    {
        $query = Order::query();
        if($user_nickname = $request->get('user_nickname')){
            $query->whereHas('user',function (Builder$builder) use($user_nickname){
                $builder->where('nickname','like',"%{$user_nickname}%");
            });
        }
        if($order_name = $request->get('order_name')){
            $query->whereHas('excavator',function (Builder$builder) use($order_name){
                $builder->where('name','like',"%{$order_name}%");
            });
        }
        $paginate = $query->with(['excavator.images','excavator.video','excavator.region','excavator.brand','user'])
            ->paginate($request->get('limit'));
        $data = OrderListResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }
    

    public function update(Request $request,int $id)
    {
        $model = $this->orders->firstModelByIdOrFail($id);
        DB::transaction(function ()use($request,$model)
        {
            list($data,$image_ids) = $this->validateOrder($request);
            $model->update($data);
            $model->imagesSync($image_ids);
        });
        return api_response()->success();
   }

    public function delete(Request $request, int $id)
    {
        $model = $this->orders->firstModelByIdOrFail($id,[],['id']);
        DB::transaction(function ()use($request,$model)
        {
            $model->delete();
            $model->imagesDetach();
        });

        return api_response()->success();
   }


    public function batchDelete(Request $request)
    {
        $this->orders->batchDelete($request->get('ids'));
        return api_response()->success();
   }
   
}
