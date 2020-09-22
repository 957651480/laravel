<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ExcavatorListResource extends JsonResource
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
        $brand = $this->brand?:optional();
        $region = $this->region?:optional();
        return [
            'id'=>(integer)$this->id,
            'title'=>(string)$this->name,
            'price'=>$this->price,
            'date_of_production'=>(string)date('Y',$this->date_of_production),
            'duration_of_use'=>(integer)$this->duration_of_use,
            'motor_model'=>(string)$this->motor_model,
            'image_url'=>(string)$images->first()->url,
            'total_cost_rmb'=>(float)$this->cost_rmb,
            'total_cost_jpn'=>(float)$this->cost_jpn,
            'region_merger_name'=>(string)$region->merger_name,
        ];
    }
}
