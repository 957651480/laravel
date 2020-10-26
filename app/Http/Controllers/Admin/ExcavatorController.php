<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\CollectListResource;
use App\Http\Resources\Admin\ExcavatorResource;
use App\Http\Resources\Admin\VisitListResource;
use App\Models\Collect;
use App\Models\Excavator;
use App\Models\Visit;
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
        $param= array_merge([
            'name'=>''
        ],$request->all());
        $query = Excavator::query();
        $name = $param['name'];
        $query->when($name,function (Builder $query,$name){
           $query->where('name','like',"%{$name}%");
        });

        $paginate = $query->orderByDesc('sort')->latest()
            ->with(['images','video','region'])->paginate($request->get('limit'));
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
        $query = Visit::query();
        if($user_nickname = $request->get('user_nickname')){
            $query->whereHas('user',function (Builder$builder) use($user_nickname){
                $builder->where('nickname','like',"%{$user_nickname}%");
            });
        }
        if($excavator_name = $request->get('excavator_name')){
            $query->whereHas('excavator',function (Builder$builder) use($excavator_name){
                $builder->where('name','like',"%{$excavator_name}%");
            });
        }
        $paginate = $query->with(['excavator.images','excavator.video','excavator.region','excavator.brand','user'])
            ->paginate($request->get('limit'));
        $data = VisitListResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }

    public function collectList(Request $request)
    {
        $query = Collect::query();
        if($user_nickname = $request->get('user_nickname')){
            $query->whereHas('user',function (Builder$builder) use($user_nickname){
                $builder->where('nickname','like',"%{$user_nickname}%");
            });
        }
        if($excavator_name = $request->get('excavator_name')){
            $query->whereHas('excavator',function (Builder$builder) use($excavator_name){
                $builder->where('name','like',"%{$excavator_name}%");
            });
        }
        $paginate = $query->with(['excavator.images','excavator.video','excavator.region','excavator.brand','user'])
            ->paginate($request->get('limit'));
        $data = CollectListResource::collection($paginate);
        return api_response()->success(['total'=>$paginate->total(),'data'=>$data]);
    }

    public function cost()
    {
        $common= [
                'name'=>'代缴税额',
                'children'=>[
                    ['name'=>'申报机价', 'rmb'=>''],
                    ['name'=>'关税8%', 'rmb'=>''],
                    ['name'=>'增值税30%', 'rmb'=>''],
                ]
            ];
        // 10T以下
        $lessThanTen=[
            $common,
            [
                'name'=>'香港费用',
                'children'=>[
                    ['name'=>'香港仓储费', 'rmb'=>'7000'],
                    ['name'=>'证书费', 'rmb'=>'5620'],
                    ['name'=>'入单费', 'rmb'=>'500'],
                    ['name'=>'影像', 'rmb'=>'300'],
                    ['name'=>'运输费', 'rmb'=>'1200'],
                    ['name'=>'过磅费', 'rmb'=>'800'],
                    ['name'=>'清关费', 'rmb'=>'150'],
                    ['name'=>'检机行政费', 'rmb'=>'500'],
                ]
            ],
            [
                'name'=>'大陆费用',
                'children'=>[
                    ['name'=>'报关费', 'rmb'=>'3120'],
                    ['name'=>'HK-莲花山', 'rmb'=>'1100'],
                    ['name'=>'莲花山-机械城', 'rmb'=>'700'],
                    ['name'=>'代理报关服务费', 'rmb'=>'3000'],
                ]
            ],
        ];
        $elevenToFifteen=[
            $common,
            [
                'name'=>'香港费用',
                'children'=>[
                    ['name'=>'香港仓储费', 'rmb'=>'7000'],
                    ['name'=>'证书费', 'rmb'=>'5620'],
                    ['name'=>'入单费', 'rmb'=>'500'],
                    ['name'=>'影像', 'rmb'=>'300'],
                    ['name'=>'运输费', 'rmb'=>'1200'],
                    ['name'=>'过磅费', 'rmb'=>'1000'],
                    ['name'=>'清关费', 'rmb'=>'150'],
                    ['name'=>'检机行政费', 'rmb'=>'1000'],
                ]
            ],
            [
                'name'=>'大陆费用',
                'children'=>[
                    ['name'=>'报关费', 'rmb'=>'3696'],
                    ['name'=>'HK-莲花山', 'rmb'=>'1400'],
                    ['name'=>'莲花山-机械城', 'rmb'=>'1200'],
                    ['name'=>'代理报关服务费', 'rmb'=>'3000'],
                ]
            ],
        ];
        $twenty=[
            $common,
            [
                'name'=>'香港费用',
                'children'=>[
                    ['name'=>'香港仓储费', 'rmb'=>'8000'],
                    ['name'=>'证书费', 'rmb'=>'5620'],
                    ['name'=>'入单费', 'rmb'=>'500'],
                    ['name'=>'影像', 'rmb'=>'300'],
                    ['name'=>'运输费', 'rmb'=>'1500'],
                    ['name'=>'过磅费', 'rmb'=>'1500'],
                    ['name'=>'清关费', 'rmb'=>'150'],
                    ['name'=>'检机行政费', 'rmb'=>'1500'],
                ]
            ],
            [
                'name'=>'大陆费用',
                'children'=>[
                    ['name'=>'报关费', 'rmb'=>'3896'],
                    ['name'=>'HK-莲花山', 'rmb'=>'1550'],
                    ['name'=>'莲花山-机械城', 'rmb'=>'1800'],
                    ['name'=>'代理报关服务费', 'rmb'=>'5000'],
                ]
            ],
        ];
        $thirtyToThirtyFive=[
            $common,
            [
                'name'=>'香港费用',
                'children'=>[
                    ['name'=>'香港仓储费', 'rmb'=>'12000'],
                    ['name'=>'证书费', 'rmb'=>'6020'],
                    ['name'=>'入单费', 'rmb'=>'500'],
                    ['name'=>'影像', 'rmb'=>'300'],
                    ['name'=>'运输费', 'rmb'=>'2600'],
                    ['name'=>'过磅费', 'rmb'=>'1800'],
                    ['name'=>'清关费', 'rmb'=>'200'],
                    ['name'=>'检机行政费', 'rmb'=>'2000'],
                ]
            ],
            [
                'name'=>'大陆费用',
                'children'=>[
                    ['name'=>'报关费', 'rmb'=>'7970'],
                    ['name'=>'HK-莲花山', 'rmb'=>'2700'],
                    ['name'=>'莲花山-机械城', 'rmb'=>'4500'],
                    ['name'=>'代理报关服务费', 'rmb'=>'10000'],
                ]
            ],
        ];
        $fortyToFifty=[
            $common,
            [
                'name'=>'香港费用',
                'children'=>[
                    ['name'=>'香港仓储费', 'rmb'=>'18000'],
                    ['name'=>'证书费', 'rmb'=>'6020'],
                    ['name'=>'入单费', 'rmb'=>'500'],
                    ['name'=>'影像', 'rmb'=>'300'],
                    ['name'=>'运输费', 'rmb'=>'7500'],
                    ['name'=>'过磅费', 'rmb'=>'2500'],
                    ['name'=>'清关费', 'rmb'=>'300'],
                    ['name'=>'检机行政费', 'rmb'=>'2500'],
                ]
            ],
            [
                'name'=>'大陆费用',
                'children'=>[
                    ['name'=>'报关费', 'rmb'=>'6700'],
                    ['name'=>'HK-莲花山', 'rmb'=>'4200'],
                    ['name'=>'莲花山-机械城', 'rmb'=>'6500'],
                    ['name'=>'代理报关服务费', 'rmb'=>'16000'],
                ]
            ],
        ];
        $list=[
            [
                'name'=>'10T以下',
                'costs'=>$lessThanTen
            ],
            [
                'name'=>'11T-15T',
                'costs'=>$elevenToFifteen
            ],
            [
                'name'=>'20T',
                'costs'=>$twenty
            ],
            [
                'name'=>'30-35T',
                'costs'=>$thirtyToThirtyFive
            ],
            [
                'name'=>'40-50T',
                'costs'=>$fortyToFifty
            ],
        ];

        return api_response()->success(['data'=>$list]);
   }

    protected function validateExcavator(Request $request)
    {
        $data = $request->validate([
            'name'=>'required',
            'brand_id'=>'required',
            'model'=>'required',
            'method'=>'sometimes',
            'price'=>'required',
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
            'price.required'=>'价格必须',
            'date_of_production.required'=>'出厂日期必须',
            'image_ids.required'=>'图片必须',
            'costs.required'=>'费用明细必须',
        ]);
        $image_ids = \Arr::pull($data,'image_ids');
        $data['date_of_production']=strtotime($data['date_of_production']);
        return [$data,$image_ids];
    }

}
