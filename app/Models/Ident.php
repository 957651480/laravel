<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ident extends EloquentModel
{
    //
    protected $guarded=[];
    protected $table='ident';

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }



    /**
     * 将查询作用域限制为仅包含给定类型的用户
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $identify
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfIdentify($query, $identify)
    {
        return $query->where('identify', $identify);
    }


    /**
     * 将查询作用域限制为仅包含给定类型的用户
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }


    public static function getUidByIdentify($identify)
    {
        return static::ofIdentify($identify)->value('user_id');
    }
}
