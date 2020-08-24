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
        return [
            'id'=>$this->id,
            'brand_id'=>$this->brand_id,
            'model'=>$this->model,
            'method'=>$this->method,
            'date_of_production'=>$this->date_of_production,
            'duration_of_use'=>$this->duration_of_use,
            'equipment_operation'=>$this->equipment_operation,
            'motor_brand'=>$this->motor_brand,
            'motor_model'=>$this->motor_model,
            'motor_rate_of_work'=>$this->motor_rate_of_work,
            'hydraulic_pump_rand'=>$this->hydraulic_pump_rand,
            'hydraulic_pump_model'=>$this->hydraulic_pump_model,
            'hydraulic_pump_flow'=>$this->hydraulic_pump_flow,
            'image_ids'=>$images->modelKeys(),
            'image_urls'=>$images->urls(),
            'video_id'=>$this->video_id,
            'video_url'=>$video->url,
            'created_at'=>(string)optional($this->created_at)->toDateTimeString(),
            'updated_at'=>(string)optional($this->updated_at)->toDateTimeString(),
        ];
    }
}
