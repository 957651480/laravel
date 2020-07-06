<?php


namespace App\Contracts;


interface EloquentRepositoryInterface
{

    public function all($column=['*']);

    public function findById(int $id);

    /**
     * @param $column
     * @param $value
     * @return EloquentModel|null
     */
    public function findByColumn($column, $value);


    /**
     * @param array $ids
     * @return EloquentCollection
     */
    public function findAllIds(array $ids);

    /**
     * @param $column
     * @param $value
     * @return EloquentCollection
     */
    public function findAllByColumn($column, $value);


    /**
     * @param array $attributes
     * @return EloquentModel
     */
    public function create(array $attributes);

    /**
     * @param EloquentModel $eloquentModel
     * @return bool
     */
    public function save(EloquentModel $eloquentModel);

    /**
     * @param array $attributes
     * @return bool
     */
    public function update(array $attributes = []);

    /**
     * @param EloquentModel $eloquentModel
     * @return bool
     */
    public function delete(EloquentModel $eloquentModel);

    /**
     * @param EloquentModel $eloquentModel
     * @return bool
     */
    public function forceDelete(EloquentModel $eloquentModel);
    /**
     * @return EloquentModel
     */
    public function getModel(): EloquentModel;


    /**
     * @param EloquentModel $model
     */
    public function setModel(EloquentModel $model): void;

    public function newModel();
}
