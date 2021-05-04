<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends ApiController
{
    /**
     * @var Brand
     */
    protected $brands;

    /**
     * BrandController constructor.
     * @param Brand $brands
     */
    public function __construct(Brand $brands)
    {
        $this->brands = $brands;
    }


    public function index(Request $request)
    {
        //
        $param =[
            'page'=>1,
            'limit'=>15,
            'name'=>'',
        ];
        $param = array_merge($param,$request->all());

        $query = $this->brands->with('image');
        if($param['name']){
            $query->where('name','like',"%{$param['name']}%");
        }
        $paginate = $query->orderByDesc('sort')->latest()->paginate($param['limit']);
        $total = $paginate->total();
        $data =BrandResource::collection($paginate);

        return api_response()->success(['total'=>$total,'data'=>$data]);
    }


    public function store(Request $request)
    {
        //
        $data = $this->validateBrand($request->all());
        $this->brands->create($data);
        return api_response()->success();
    }


    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
        $banner = $this->brands->firstModelByIdOrFail($id);
        $data = $this->validateBrand($request->all());
        $banner->update($data);
        return api_response()->success();
    }


    public function destroy($id)
    {
        //
        $banner = $this->brands->firstModelByIdOrFail($id);
        $banner->delete();
        return api_response()->success();
    }

    public function batchDelete(Request $request)
    {
        $this->brands->whereIn('id',$request->get('ids'))->delete();
        return api_response()->success();
    }

    protected function validateBrand($from)
    {
        $rules =[
            'name'=>'required',
            'image_id'=>'required',
            'show'=>'sometimes',
            'sort'=>'sometimes'
        ];
        $validator = \Validator::make($from,$rules,
            [
                'title.required'=>'名称必填',
                'image_id.required'=>'图片必传',
            ]
        );
        throw_if($validator->fails(),ApiException::class,$validator->messages()->first());
        return $validator->validated();
    }
}