<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collect extends Model
{
    //
    protected $table='collect';
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
