<?php


namespace App\Repositories;

use App\Contracts\EloquentRepositoryInterface;
use App\Models\EloquentModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class EloquentRepository
 * @package App\Repositories
 * @mixin \Eloquent
 */
class EloquentRepository implements EloquentRepositoryInterface
{

    /**
     * @var EloquentModel
     */
    protected $model;


    public function all($column=['*'])
    {
        return $this->model->all($column);
    }
    /**
     * @param array|int $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|Contracts\EloquentCollection|EloquentModel|EloquentModel[]|null
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }


    /**
     * @param $column
     * @param $value
     * @return \Illuminate\Database\Eloquent\Model|EloquentModel|object|null
     */
    public function findByColumn($column, $value)
    {
        return $this->model->where($column, $value)->first();
    }


    /**
     * @param array $ids
     * @return \Illuminate\Database\Eloquent\Collection|Contracts\EloquentCollection|EloquentModel[]
     */
    public function findAllIds(array $ids)
    {
        return $this->model->whereIn('id',$ids)->get();
    }


    /**
     * @param $column
     * @param $value
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection|Contracts\EloquentCollection|EloquentModel[]
     */
    public function findAllByColumn($column, $value)
    {
        return $this->model->whereColumn($column,'=',$value)->get();
    }


    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model|EloquentModel
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $attributes
     * @return bool|int
     */
    public function update(array $attributes = [])
    {
        return $this->model->update($attributes);
    }

    /**
     * @param EloquentModel $eloquentModel
     * @return bool
     */
    public function save(EloquentModel $eloquentModel)
    {
        return $eloquentModel->save();
    }

    /**
     * @param EloquentModel $eloquentModel
     * @return bool|mixed
     */
    public function delete(EloquentModel $eloquentModel)
    {
        return $eloquentModel->delete();
    }

    /**
     * @param EloquentModel $eloquentModel
     * @return bool|mixed
     */
    public function forceDelete(EloquentModel $eloquentModel)
    {
        return $eloquentModel->forceDelete();
    }

    /**
     * @return EloquentModel
     */
    public function getModel(): EloquentModel
    {
        return $this->model;
    }


    /**
     * @param EloquentModel $model
     */
    public function setModel(EloquentModel $model): void
    {
        $this->model = $model;
    }

    public function newModel()
    {
        return clone $this->model;
    }

    public function newQuery()
    {
        return $this->model->newQuery();
    }


    /**
     * @param Builder $query
     * @param int $page
     * @param int $limit
     * @return Builder
     */
    public function apiPaginate(Builder $query,int $page=1,int $limit=10)
    {
        return $query->skip(($page - 1) * $limit)->take($limit+1);
    }
}
