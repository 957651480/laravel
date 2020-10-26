<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use App\Models\SysSetting;
use Illuminate\Http\Request;

/**
 * Class BannerController
 * @package App\Http\Controllers\Api\Backend
 */
class SysSettingController extends ApiController
{

    /**
     * @var SysSetting
     */
    protected $sysSetting;

    /**
     * RegionController constructor.
     * @param SysSetting $sysSetting
     */
    public function __construct(SysSetting $sysSetting)
    {
        $this->sysSetting = $sysSetting;
    }


    public function detail(Request $request)
    {
        if(!$model = $this->sysSetting->first()){
            $data= [
                'future_desc'=>'',
                'serviceEnsure'=>[]
            ];
        }else{
            $data=$model->value;
        }
        return api_response()->success(['data'=>$data]);
   }

    public function save(Request $request)
    {
        if($model = $this->sysSetting->first()){
            $model->setRawAttributes($request->all());
            $model->save();
        }else{
            $this->sysSetting->create(['key'=>'base','value'=>$request->post()]);
        }
        return api_response()->success();
   }

}
