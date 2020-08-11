<?php

namespace App\Models;



class FileGroup extends EloquentModel
{
    //
    protected $table='file_group';

    protected $guarded=[];


    public function files()
    {
        return $this->hasMany(File::class,'group_id');
    }
}
