<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $image = $this->image?:optional();
        return [
            'id'=>$this->id,
            'sort'=>$this->sort,
            'title'=>$this->title,
            'desc'=>$this->desc,
            'image_id'=>$this->image_id,
            'image_url'=>$image->url,
            'show'=>$this->show,
            'created_at'=>(string)optional($this->created_at)->toDateTimeString(),
            'updated_at'=>(string)optional($this->updated_at)->toDateTimeString(),
        ];
    }
}
