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
 * @property int $id
 * @property int $sort 排序
 * @property string $title 标题
 * @property string $desc 简介
 * @property int $image_id 图片id
 * @property string $link 链接
 * @property int $show 是否显示：10显示,20隐藏
 * @property string|null $deleted_at 删除时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\File $image
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner show($show = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereShow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereUpdatedAt($value)
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