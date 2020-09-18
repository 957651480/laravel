<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    //
    protected $table='reserve';
    protected $guarded=[];

    public function excavator()
    {
        return $this->hasOne(Excavator::class,'excavator_id');
    }
}
