<?php

namespace App\Models;

class SysRegion extends EloquentModel
{
    //
    protected $table='sys_region';
    protected $guarded=[];


    public function children() {
        return $this->hasMany(SysRegion::class, 'parent_id', 'id');
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @param  mixed  $parent_id
     * @param  mixed  $operator
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeParentId($query,$parent_id=0,$operator='=')
    {
        return $query->where($this->qualifyColumn('parent_id'),$operator, $parent_id);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @param  mixed  $name
     * @param  mixed  $operator
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeName($query, $name, $operator='=')
    {
        return $query->where($this->qualifyColumn('name'),$operator, $name);
    }



    public function topList()
    {
        //todo distinct 分页总数无效，使用group by
        $prefix = \DB::getConfig('prefix');

        $sub = self::select('parent_id')->parentId(0,'>');
        $has_children = \DB::raw("if({$prefix}r.parent_id={$prefix}sys_region.id,1,0) as has_children");
        $query = self::select([
            'sys_region.*',
            $has_children
            ])->leftJoinSub($sub,'r','sys_region.id','r.parent_id')
            ->groupBy('sys_region.id');
        return $query;
    }
}