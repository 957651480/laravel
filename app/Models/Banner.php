<?php

namespace App\Models;



/**
 * App\Models\Banner
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner query()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EloquentModel apiPaginate($limit = 10)
 */
class Banner extends EloquentModel
{
    //
    protected $table='banner';
    protected $guarded=[];


    public function image()
    {
        return $this->belongsTo(File::class,'image_id');
    }

    /**
     *
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeShow($query, $show=true)
    {
        return $query->where('show', $show?10:20);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function bannerList()
    {
        return $this->with('image')->show()->orderByDesc('sort')->limit(3)->get([
            'title','desc','image_id'
        ]);
    }
}
