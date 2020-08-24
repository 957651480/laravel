<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Excavator extends Model
{
    //
    protected $table='excavator';
    protected $guarded=[];

    public function video()
    {
        return $this->belongsTo(File::class,'video_id');
    }

    public function images()
    {
        return $this->belongsToMany(File::class,'excavator_image','excavator_id','image_id');
    }
}
