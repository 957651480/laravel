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


    public function batchDelete(array $ids)
    {
        return $this->whereIn('id',$ids)->delete();
    }

    public  static function firstModelByPrimaryKey($key,$with=[],$columns = ['*'])
    {
        $query = static::query();
        if($with){
            $query->with($with);
        }
        return $query->whereKey($key)->first($columns);
    }

    public  function firstModelByIdOrFail(int $key,$with=[],$columns = ['*'])
    {
        self::firstModelByPrimaryKey($key);
        return $this->whereKey($id)->firstOrFail($columns);
    }

    public static function getCacheKey()
    {
        return get_called_class();
    }

    public static function flushCacheKey()
    {
        cache()->forget(self::getCacheKey());
    }
}
