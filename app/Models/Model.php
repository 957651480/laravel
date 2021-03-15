<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as Eloquent;


/**
 * App\Models\EloquentModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EloquentModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EloquentModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EloquentModel query()
 * @mixin Builder
 */
class Model extends Eloquent
{


    /**
     * @param integer|string $key
     * @param array $with
     * @param string[] $columns
     * @return Model|Builder|Model|object|null
     */
    public  static function firstModelByPrimaryKey($key,$with=[],$columns = ['*'])
    {
        return static::query()->with($with)->whereKey($key)->first($columns);
    }


    /**
     * @param $key
     * @param array $with
     * @param string[] $columns
     * @return Model|Builder|Model|object
     * @throws @\Exception
     */
    public  function firstModelByPrimaryKeyOrFail($key,$with=[],$columns = ['*'])
    {
        return static::query()->with($with)->whereKey($key)->firstOrFail($columns);
    }

    public static function batchUpdate($model, array $values, $index = null){
        $final = [];
        $ids = [];
        if (!count($values)) {
            return false;
        }
        if (!isset($index) || empty($index)) {
            $index = $model->getKeyName();
        }
        foreach ($values as $key => $val) {
            $ids[] = $val[$index];
            foreach (array_keys($val) as $field) {
                if ($field !== $index) {
                    $value = (is_null($val[$field]) ? 'NULL' : '"' . $val[$field]) . '"';
                    $final[$field][] = 'WHEN `' . $index . '` = "' . $val[$index] . '" THEN ' . $value . ' ';
                }
            }
        }
        $cases = '';
        foreach ($final as $k => $v) {
            $cases .= '`' . $k . '` = (CASE ' . implode("\n", $v) . "\n"
                . 'ELSE `' . $k . '` END), ';
        }
        $full_table     =  $model->getConnection()->getTablePrefix() . $model->getTable();
        $query = "UPDATE `" .$full_table . "` SET " . substr($cases, 0, -2) . " WHERE `$index` IN(" . '"' . implode('","', $ids) . '"' . ");";
        \DB::update($query);
    }
}
