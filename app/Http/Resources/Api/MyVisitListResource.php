<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class MyVisitListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $excavator = $this->excavator?:optional();
        $excavator_images = $excavator->images;
        $excavator_region = $excavator->region?:optional();
        $excavator_brand = $this->brand?:optional();


        return [
            'id'=>(integer)$this->id,
            'name'=>(string)$excavator->name,
            'price'=>$excavator->price,
            'date_of_production'=>(string)date('Y',$excavator->date_of_production),
            'duration_of_use'=>(integer)$excavator->duration_of_use,
            'motor_model'=>(string)$excavator->motor_model,
            'image_url'=>(string)$excavator_images->first()->url,
            'total_cost_rmb'=>$excavator->cost_rmb,
            'total_cost_jpn'=>$excavator->cost_jpn,
            'region_merger_name'=>(string)$excavator_region->merger_name,
        ];
    }
}
