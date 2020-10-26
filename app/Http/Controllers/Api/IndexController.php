<?php


namespace App\Http\Controllers\Api;


use App\Cache\ExchangeRate;
use App\Cache\ExchangeRateCache;
use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\BannerResource;
use App\Models\Banner;
use App\Models\SysSetting;
use Illuminate\Http\Request;

/**
 * Class BannerController
 * @package App\Http\Controllers\Api\Backend
 */
class IndexController extends ApiController
{


    public function index(Request $request,Banner $banner)
    {
        $paginate = $this->banners->with('image')->paginate($request->get('limit'));
        $data = BannerResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }

    public function rate()
    {
        $rate = ExchangeRateCache::fetchJapan();
        return api_response()->success(['data'=>$rate]);
    }

    public function setting()
    {
        if(!$model = SysSetting::first()){
            $data= [
                'future_desc'=>'',
                'serviceEnsure'=>[]
            ];
        }else{
            $data=$model->value;
        }
        return api_response()->success(['data'=>$data]);
    }
}
