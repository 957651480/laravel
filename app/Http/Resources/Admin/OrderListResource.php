<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
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
            'total_cost_rmb'=>(float)number_format($excavator->cost_rmb/10000,2),
            'total_cost_jpn'=>(float)number_format($excavator->cost_jpn/10000,2),
            'region_merger_name'=>(string)$excavator_region->merger_name,
            'visit_user_nickname'=>optional($this->user)->nickname,
            'visit_user_avatar'=>optional($this->user)->avatar,
            'visit_created_at'=>optional($this->created_at)->toDateTimeString(),
        ];
    }
}
