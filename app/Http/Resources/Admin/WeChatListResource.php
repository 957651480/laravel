<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class WeChatListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $typeAndIdentify = $this->indents->pluck('identify','type')->toArray();
        return array_merge([
            'id' => $this->id,
            'nickname' => $this->nickname,
            'avatar' =>$this->avatar,
            'created_at'=>(string)optional($this->created_at)->toDateTimeString(),
            'updated_at'=>(string)optional($this->updated_at)->toDateTimeString(),
        ],$typeAndIdentify);
    }
}
