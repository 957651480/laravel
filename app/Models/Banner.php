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
}
