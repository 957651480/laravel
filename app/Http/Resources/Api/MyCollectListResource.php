<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class MyCollectListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $excavator = $this->excavator;
        $brand = $excavator->brand;
        $images = $excavator->images;

        return [
            'id'=>$this->id,
            'excavator_id'=>$this->excavator_id,
            'brand_name'=>$brand->name,
            'model'=>$this->model,
            'method'=>$this->method,
            'date_of_production'=>date('Y-m-d',$this->date_of_production),
            'duration_of_use'=>$this->duration_of_use,
            'image_url'=>$images->first()->url,
            'created_at'=>(string)optional($this->created_at)->toDateTimeString(),
            'updated_at'=>(string)optional($this->updated_at)->toDateTimeString(),
        ];
    }
}
