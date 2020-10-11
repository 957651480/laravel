<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ExcavatorDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $images = $this->images;
        $video = $this->video?:optional();
        $brand = $this->brand?:optional();
        $region = $this->region?:optional();

        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'brand_name'=>$brand->name,
            'model'=>$this->model,
            'method'=>$this->method,
            'date_of_production'=>date('Y',$this->date_of_production),
            'duration_of_use'=>$this->duration_of_use,
            'equipment_operation'=>$this->equipment_operation,
            'motor_brand'=>$this->motor_brand,
            'motor_model'=>$this->motor_model,
            'motor_rate_of_work'=>$this->motor_rate_of_work,
            'hydraulic_pump_rand'=>$this->hydraulic_pump_rand,
            'hydraulic_pump_model'=>$this->hydraulic_pump_model,
            'hydraulic_pump_flow'=>$this->hydraulic_pump_flow,
            'image_urls'=>$images->urls(),
            'video_url'=>(string)$video->url,
            'costs'=>$this->costs,
            'total_cost_rmb'=>(float)$this->cost_rmb,
            'total_cost_jpn'=>(float)$this->cost_jpn,
            'region_merger_name'=>$region->merger_name,
            'weight'=>$this->weight,
            'recommend'=>(integer)$this->recommend,
            'sort'=>$this->sort,
            'price'=>$this->price,
            'created_at'=>(string)optional($this->created_at)->toDateTimeString(),
            'updated_at'=>(string)optional($this->updated_at)->toDateTimeString(),
        ];
    }
}
