<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ExcavatorResource extends JsonResource
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
            'brand_id'=>$this->brand_id,
            'brand_name'=>$brand->name,
            'model'=>$this->model,
            'method'=>$this->method,
            'date_of_production'=>date('Y-m-d',$this->date_of_production),
            'duration_of_use'=>$this->duration_of_use,
            'equipment_operation'=>$this->equipment_operation,
            'motor_brand'=>$this->motor_brand,
            'motor_model'=>$this->motor_model,
            'motor_rate_of_work'=>$this->motor_rate_of_work,
            'hydraulic_pump_rand'=>$this->hydraulic_pump_rand,
            'hydraulic_pump_model'=>$this->hydraulic_pump_model,
            'hydraulic_pump_flow'=>$this->hydraulic_pump_flow,
            'image_ids'=>$images->modelKeys(),
            'image_urls'=>$images,
            'video_id'=>$this->video_id,
            'video_url'=>$video->url,
            'costs'=>$this->costs,
            'region_id'=>$this->region_id,
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
