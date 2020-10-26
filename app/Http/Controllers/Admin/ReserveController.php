<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\ReserveListResource;
use App\Models\Order;
use App\Models\Reserve;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;


class ReserveController extends ApiController
{

    protected $reserves;


    public function __construct(Reserve $reserves)
    {
        $this->reserves = $reserves;
    }


    public function index(Request $request)
    {
        $query = Reserve::query();
        $query->has('excavator');
        if ($user_nickname = $request->get('user_nickname')) {
            $query->whereHas('user', function (Builder $builder) use ($user_nickname) {
                $builder->where('nickname', 'like', "%{$user_nickname}%");
            });
        }
        if ($reserve_name = $request->get('reserve_name')) {
            $query->whereHas('excavator', function (Builder $builder) use ($reserve_name) {
                $builder->where('name', 'like', "%{$reserve_name}%");
            });
        }
        $paginate = $query->with(['excavator.images', 'excavator.video', 'excavator.region', 'excavator.brand', 'user'])
            ->paginate($request->get('limit'));
        $data = ReserveListResource::collection($paginate);
        return api_response()->success(['total' => $paginate->total(), 'data' => $data]);
    }

    public function generateOrder(Request $request, $id)
    {

        $reserve = $this->reserves->firstModelByIdOrFail($id);
        $data = $reserve->only(['user_id','price','excavator_id']);
        Order::create($data);
        return api_response()->success();
    }

}
