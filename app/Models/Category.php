<?php

namespace App\Models;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name 名称
 * @property int $parent_id 父类id
 * @property string $seo_title seo标题
 * @property string $seo_keyword seo关键词
 * @property string $seo_description seo描述
 * @property int $show 是否显示：10显示,20隐藏
 * @property string|null $deleted_at 删除时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $children
 * @property-read int|null $children_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category show($show = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category top()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereSeoKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereShow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends EloquentModel
{
    //
    protected $table='category';
    protected $guarded=[];



    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function tree()
    {
        return $this->children()->with('tree');
    }

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
