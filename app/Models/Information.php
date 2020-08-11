<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    //

    protected $table='information';

    protected $guarded=[];


    public function images()
    {
        return $this->belongsToMany(File::class,'group_id');
    }
}
