<?php

namespace App\Models\Sys;

use App\Models\EloquentModel;

class SysRegion extends EloquentModel
{
    //
    protected $table='sys_region';
    protected $guarded=[];


    public function children() {
        return $this->hasMany(SysRegion::class, 'parent_id', 'id');
    }
}
