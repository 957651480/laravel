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

    /**
     * @param integer|string $key
     * @param array $with
     * @param string[] $columns
     * @return EloquentModel|Builder|Model|object|null
     */
    public  static function firstModelByPrimaryKey($key,$with=[],$columns = ['*'])
    {
        $query = static::query();
        if($with){
            $query->with($with);
        }
        return $query->whereKey($key)->first($columns);
    }


    /**
     * @param $key
     * @param array $with
     * @param string[] $columns
     * @return EloquentModel|Builder|Model|object
     * @throws @\Exception
     */
    public  function firstModelByPrimaryKeyOrException($key,$with=[],$columns = ['*'])
    {
        if (! is_null($model = static::firstModelByPrimaryKey($key,$with,$columns))) {
            return $model;
        }
        throw new \Exception("dddd");
    }

}
