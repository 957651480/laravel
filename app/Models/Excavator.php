<?php

namespace App\Models;

use App\Cache\ExchangeRateCache;
use App\Casts\Json;


class Excavator extends EloquentModel
{
    //
    protected $table='excavator';
    protected $casts=[
        'costs'=>Json::class
    ];
    protected $guarded=[];

    public function video()
    {
        return $this->belongsTo(File::class,'video_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }

    public function region()
    {
        return $this->belongsTo(SysRegion::class,'region_id');
    }

    public function visit()
    {
        return $this->hasOne(Visit::class,'excavator_id');
    }
    public function visits()
    {
        return $this->hasMany(Visit::class,'excavator_id');
    }

    public function collect()
    {
        return $this->hasOne(Collect::class,'excavator_id');
    }

    public function collects()
    {
        return $this->hasMany(Collect::class,'excavator_id');
    }
    public function images()
    {
        return $this->belongsToMany(
            File::class,'excavator_image',
            'excavator_id','image_id')->select(['id','name','path']);
    }

    public function imagesAttach($id, array $attributes = [], $touch = true)
    {
        return $this->images()->attach($id,  $attributes = [], $touch);
    }

    public function imagesDetach($ids = null, $touch = true)
    {
        return $this->images()->detach($ids, $touch);
    }

    public function imagesSync($ids, $detaching = true)
    {
        return $this->images()->sync($ids, $detaching);
    }


    public function getCostRmbAttribute()
    {
        $rmb_list=[];
        $costs = $this->costs;
        array_walk_recursive($costs,function ($value, $key)use(&$rmb_list){
            if($key=='rmb'){
                $rmb_list[]=$value;
            }
        });
        return array_sum($rmb_list);
    }

    public function getCostJpnAttribute()
    {
        $rate = ExchangeRateCache::fetchJapan();
        $jpn_list=[];
        $costs = $this->costs;
        array_walk_recursive($costs,function ($value, $key,$rate)use(&$jpn_list){
            if($key=='rmb'){
                $jpn_list[]=$value*$rate;
            }
        },$rate);
        return array_sum($jpn_list);
    }
}
