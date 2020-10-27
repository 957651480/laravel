<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ReserveListResource extends JsonResource
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

        return [
            'id'=>(integer)$this->id,
            'name'=>(string)$excavator->name,
            'price'=>$this->price,
            'date_of_production'=>(string)date('Y',$excavator->date_of_production),
            'duration_of_use'=>(integer)$excavator->duration_of_use,
            'motor_model'=>(string)$excavator->motor_model,
            'image_url'=>(string)$excavator_images->first()->url,
            'total_cost_rmb'=>(float)$excavator->cost_rmb,
            'total_cost_jpn'=>(float)$excavator->cost_jpn,
            'region_merger_name'=>(string)$excavator->address,
            'visit_user_nickname'=>optional($this->user)->nickname,
            'visit_user_avatar'=>optional($this->user)->avatar,
            'visit_created_at'=>optional($this->created_at)->toDateTimeString(),
        ];
    }
}
