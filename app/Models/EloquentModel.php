<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\EloquentModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EloquentModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EloquentModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EloquentModel query()
 * @mixin Builder
 */
class EloquentModel extends Model
{


    public static function batchDelete(array $ids)
    {
        return static::whereIn('id',$ids)->delete();
    }

    public  static function firstModelById(int $id,$with=[],$columns = ['*'])
    {
        if($with){
            static::with($with);
        }
        return static::whereKey($id)->first($columns);
    }

    public static function firstModelByIdOrFail(int $id,$with=[],$columns = ['*'])
    {
        if($with){
            static::with($with);
        }
        return static::whereKey($id)->firstOrFail($columns);
    }
}
