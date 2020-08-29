<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\ExcavatorResource;
use App\Models\Excavator;
use DB;
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


    public function create(Request $request)
    {

        DB::transaction(function ()use($request)
        {
            list($data,$image_ids) = $this->validateExcavator($request);
            $model = $this->excavators->create($data);
            $model->imagesAttach($image_ids);
        });
        return api_response()->success();
   }

    public function detail(Request $request,int $id)
    {
        $model = $this->excavators->firstModelByIdOrFail($id,['images','video']);
        $data = new ExcavatorResource($model);
        return api_response()->success(['data'=>$data]);
   }

    public function update(Request $request,int $id)
    {
        $model = $this->excavators->firstModelByIdOrFail($id);
        DB::transaction(function ()use($request,$model)
        {
            list($data,$image_ids) = $this->validateExcavator($request);
            $model->update($data);
            $model->imagesSync($image_ids);
        });
        return api_response()->success();
   }

    public function delete(Request $request, int $id)
    {
        $model = $this->excavators->firstModelByIdOrFail($id,[],['id']);
        DB::transaction(function ()use($request,$model)
        {
            $model->delete();
            $model->imagesDetach();
        });

        return api_response()->success();
   }


    public function batchDelete(Request $request)
    {
        $this->excavators->batchDelete($request->get('ids'));
        return api_response()->success();
   }

    protected function validateExcavator(Request $request)
    {
        $data = $request->validate([
            'brand_id'=>'required',
            'model'=>'required',
            'method'=>'sometimes',
            //'date_of_production'=>'required',
            'duration_of_use'=>'sometimes',
            'equipment_operation'=>'sometimes',
            'motor_brand'=>'sometimes',
            'motor_model'=>'sometimes',
            'motor_rate_of_work'=>'sometimes',
            'hydraulic_pump_rand'=>'sometimes',
            'hydraulic_pump_model'=>'sometimes',
            'hydraulic_pump_flow'=>'sometimes',
            'image_ids'=>'required',
            'video_id'=>'sometimes',
        ],[
            'brand_id.required'=>'品牌必须',
            'model.required'=>'型号必须',
            'date_of_production.required'=>'出厂日期必须',
            'image_ids.required'=>'图片必须',
        ]);
        $image_ids = \Arr::pull($data,'image_ids');
        return [$data,$image_ids];
    }

}
