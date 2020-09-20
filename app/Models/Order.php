<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends EloquentModel
{
    //
    protected $table='order';
    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function excavator()
    {
        return $this->belongsTo(Excavator::class,'excavator_id');
    }
}
