<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    //
    protected $table='bid';
    protected $guarded=[];

    public function excavator()
    {
        return $this->hasOne(Excavator::class,'excavator_id');
    }
}
