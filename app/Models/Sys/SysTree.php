<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysTree extends Model
{
    use HasFactory;


    /**
     * @param  string $path
     * @param string[] $columns
     * @return mixed
     */
    public static function conf(string $path,array $columns = ['id','tag','name','value'])
    {
        return static::where('path',$path)->first($columns);
    }
}
