<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    //
    protected $table='visit';
    protected $guarded=[];

    public function excavator()
    {
        return $this->hasOne(Excavator::class,'excavator_id');
    }
}
