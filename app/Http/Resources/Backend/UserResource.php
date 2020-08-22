<?php

namespace App\Http\Resources\Backend;

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
        $permissions = $this->getAllPermissions();
        return [
            'id' => $this->id,
            'username' => $this->username,
            'nickName' => $this->nickName,
            'role_list' => $this->roles,
            'permission_list' => $permissions,
            'open_id'=>$this->open_id,
            'avatar' =>$this->avatarUrl,
            'token'=>$this->token,
            'roles' => array_map(
                function ($role) {
                    return $role['name'];
                },
                $this->roles->toArray()
            ),
            'permissions' => array_map(
                function ($permission) {
                    return $permission['name'];
                },
                $permissions->toArray()
            ),
            'created_at'=>(string)optional($this->created_at)->toDateTimeString(),
            'updated_at'=>(string)optional($this->updated_at)->toDateTimeString(),
        ];
    }
}
