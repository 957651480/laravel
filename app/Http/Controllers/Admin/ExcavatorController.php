<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\CollectListResource;
use App\Http\Resources\Admin\ExcavatorResource;
use App\Http\Resources\Admin\VisitListResource;
use App\Models\Excavator;
use DB;
use Illuminate\Database\Eloquent\Builder;
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
        $paginate = Excavator::with(['images','video','region'])->paginate($request->get('limit'));
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


    public function visitList(Request $request)
    {
        $query = $this->excavators->newQuery();

        if($nickname = $request->get('nickname')){
            $query->whereHas('visit.user',function (Builder$builder) use($nickname){
                $builder->where('nickname','like',"%{$nickname}%");
            });
        }else{
            $query->has('visit');
        }
        $paginate = $query->with(['images','video','region','brand','visit.user'])
            ->paginate($request->get('limit'));
        $data = VisitListResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }

    public function collectList(Request $request)
    {
        $query = $this->excavators->newQuery();

        if($nickname = $request->get('nickname')){
            $query->whereHas('collect.user',function (Builder$builder) use($nickname){
                $builder->where('nickname','like',"%{$nickname}%");
            });
        }else{
            $query->has('collect');
        }
        $paginate = $query->with(['images','video','region','brand','collect.user'])
            ->paginate($request->get('limit'));
        $data = CollectListResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }

    public function cost()
    {
        $costs= [
            [
                'name'=>'代缴税额',
                'children'=>[
                    [
                        'name'=>'申报机价',
                        'rmb'=>'',
                        'jpn'=>''
                    ],
                    [
                        'name'=>'增值税30%',
                        'rmb'=>'',
                        'jpn'=>''
                    ],
                    [
                        'name'=>'关税8%',
                        'rmb'=>'',
                        'jpn'=>''
                    ],
                ]
            ],
            [
                'name'=>'香港中检费',
                'children'=>[
                    [
                        'name'=>'证书费',
                        'rmb'=>'',
                        'jpn'=>''
                    ],
                    [
                        'name'=>'入单费',
                        'rmb'=>'',
                        'jpn'=>''
                    ],
                    [
                        'name'=>'影像',
                        'rmb'=>'',
                        'jpn'=>''
                    ],
                    [
                        'name'=>'运输费',
                        'rmb'=>'',
                        'jpn'=>''
                    ],
                    [
                        'name'=>'过磅费',
                        'rmb'=>'',
                        'jpn'=>''
                    ],
                    [
                        'name'=>'清关费',
                        'rmb'=>'',
                        'jpn'=>''
                    ],
                    [
                        'name'=>'减产行政费',
                        'rmb'=>'',
                        'jpn'=>''
                    ],
                ]
            ],
            [
                'name'=>'运输费',
                'children'=>[
                    [
                        'name'=>'HK-莲花山运输费',
                        'rmb'=>'',
                        'jpn'=>''
                    ],
                    [
                        'name'=>'莲花山-机械城运输',
                        'rmb'=>'',
                        'jpn'=>''
                    ],
                ]
            ],
            [
                'name'=>'报关服务费',
                'children'=>[
                    [
                        'name'=>'港口包干费用',
                        'rmb'=>'',
                        'jpn'=>''
                    ],
                    [
                        'name'=>'渡机费',
                        'rmb'=>'',
                        'jpn'=>''
                    ],
                ]
            ],

        ];

        return api_response()->success(['data'=>$costs]);
   }

    protected function validateExcavator(Request $request)
    {
        $data = $request->validate([
            'name'=>'required',
            'brand_id'=>'required',
            'model'=>'required',
            'method'=>'sometimes',
            'date_of_production'=>'required',
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
            'costs'=>'required',
            'region_id'=>'sometimes',
            'weight'=>'sometimes',
            'recommend'=>'sometimes',
            'sort'=>'sometimes',
        ],[
            'name.required'=>'挖机名称必须',
            'brand_id.required'=>'品牌必须',
            'model.required'=>'型号必须',
            'date_of_production.required'=>'出厂日期必须',
            'image_ids.required'=>'图片必须',
            'costs.required'=>'费用明细必须',
        ]);
        $image_ids = \Arr::pull($data,'image_ids');
        $data['date_of_production']=strtotime($data['date_of_production']);
        return [$data,$image_ids];
    }

}
