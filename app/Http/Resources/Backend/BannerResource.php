<?php

namespace App\Http\Resources\Backend;

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
        $file = $this->file?:optional();
        return [
            'id'=>$this->id,
            'sort'=>$this->sort,
            'title'=>$this->title,
            'file_id'=>$this->file_id,
            'img_url'=>$file->url,
            'show'=>$this->show,
            'created_at'=>(string)optional($this->created_at)->toDateTimeString(),
            'updated_at'=>(string)optional($this->updated_at)->toDateTimeString(),
        ];
    }
}
