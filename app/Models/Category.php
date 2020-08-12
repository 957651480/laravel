<?php

namespace App\Models;



class Category extends EloquentModel
{
    //
    protected $table='banner';
    protected $guarded=[];


    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTop($query)
    {
        return $query->where('parent_id', 0);
    }


    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeShow($query, $show=true)
    {
        return $query->where('show', $show?10:20);
    }
}
