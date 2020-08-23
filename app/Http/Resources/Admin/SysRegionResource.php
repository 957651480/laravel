<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SysRegionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => (integer)$this->id,
            'name' => (string)$this->name,
            'short_name' => (string)$this->short_name,
            'merger_name' => (string)$this->merger_name,
            'parent_id' => (integer)$this->parent_id,
            'level' => (integer)$this->level,
            'pinyin' => (string)$this->pinyin,
            'code' => (string)$this->code,
            'zip_code' => (string)$this->zip_code,
            'first' => (string)$this->first,
            'lng' => (string)$this->lng,
            'lat' => (string)$this->lat,
            'has_children'=>(integer)$this->has_children,
            //'children'=>[],
        ];
    }
}
