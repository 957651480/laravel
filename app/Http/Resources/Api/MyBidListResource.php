<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class MyBidListResource extends JsonResource
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
            'date_of_production'=>(string)date('Y',$this->date_of_production),
            'duration_of_use'=>(integer)$this->duration_of_use,
            'motor_model'=>(string)$this->motor_model,
            'image_url'=>(string)$images->first()->url,
            'total_cost_rmb'=>(float)number_format($this->cost_rmb/10000,2),
            'total_cost_jpn'=>(float)number_format($this->cost_jpn/10000,2),
            'region_merger_name'=>(string)$region->merger_name,
        ];
    }
}
