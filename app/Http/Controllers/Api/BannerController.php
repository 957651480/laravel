<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\BannerResource;
use App\Models\Banner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class BannerController
 * @package App\Http\Controllers\Api\Backend
 */
class BannerController extends ApiController
{
    /**
     * @var $banners Banner
     */
   protected $banners;

    /**
     * BannerController constructor.
     * @param Banner $banners
     */
    public function __construct(Banner $banners)
    {
        $this->banners = $banners;
    }


    public function index(Request $request)
    {
        $param=array_merge([
            'page'=>1,
            'limit'=>15,
            'show'=>''
        ],$request->all());
        $paginate = $this->banners->with('image')
            ->when(data_get($param,'show'),function (Builder $query,$show){
                $query->where('show',$show);
            })->paginate(data_get($param,'limit'));
        $data = BannerResource::collection($paginate)->toArray($request);
        $total=$paginate->total();
        return api_response()->success(['total'=>$total,'data'=>$data]);
    }

}