<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $is_login=0;
        $typeAndIdentify = $this->indentTypeAndIdentify();
        if(!$phone = data_get($typeAndIdentify,'phone')){
            $is_login=2;
        }
        $data = array_merge([
            'id' => $this->id,
            'nickname' => $this->nickname,
            'avatar' =>$this->avatar,
            'token'=>$this->token,
            'is_login'=>$is_login,
            'session_key'=>$this->session_key,
            'created_at'=>(string)optional($this->created_at)->toDateTimeString(),
            'updated_at'=>(string)optional($this->updated_at)->toDateTimeString(),
        ],$typeAndIdentify);
        return $data;
    }
}
