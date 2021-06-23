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

    /**
     * 虚拟表查询
     * @param \Illuminate\Database\Query\Builder $query
     * @param $values
     * @return string
     */
    public static function dualSelect( \Illuminate\Database\Query\Builder $query,$values)
    {
        $grammar = $query->getGrammar();
        $values = $grammar->quoteString($values);
        $sql = $grammar->compileSelect($query);
        return sprintf("select %s form dual WHERE NOT EXISTS (%s)",implode(",",$values),$sql);
    }


    /**
     * 并发插入数据
     * @param $data
     * @param $where
     * @return int
     */
    public static function insertNotExist($data,$where)
    {
        $query = static::query()->getQuery();
        $query->where($where);
        $connection = $query->getConnection();
        $grammar = $query->getGrammar();
        $field_keys=array_keys($data);
        $select_sql = static::dualSelect($query,array_values($data));
        $insertQuery = sprintf("INSERT into  %s (%s) %s",$grammar->wrapTable($query->from),$grammar->columnize($field_keys),$select_sql);
        return $connection->affectingStatement(
            $insertQuery,
            $query->cleanBindings($query->getBindings())
        );
    }

    /**
     * 批量更新
     * @param $model
     * @param array $values
     * @param null $index
     * @return bool
     */
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
