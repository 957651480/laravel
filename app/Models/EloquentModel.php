<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;


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

    public static function firstModelById(int $id,$columns = ['*'],$with=[])
    {
        return static::when($with,function (EloquentModel $model,$with){
            $model->with($with);
        })->whereKey($id)->first($columns);
    }

    public static function firstModelByIdOrFail(int $id,$columns = ['*'],$with=[])
    {
        $model = static::firstModelById($id,$columns,$with);
        throw_unless($model,ModelNotFoundException::class);
        return $model;
    }

}
