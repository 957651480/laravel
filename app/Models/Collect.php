<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collect extends Model
{
    //
    protected $table='collect';
    protected $guarded=[];

    public function excavator()
    {
        return $this->hasOne(Excavator::class,'excavator_id');
    }
}
