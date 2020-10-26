<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysSetting extends Model
{
    protected $table='sys_setting';
    protected $guarded=[];
    protected $casts=[
        'value'=>Json::class,
    ];
    use HasFactory;
}
