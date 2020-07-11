<?php


namespace App\Services;


use App\Models\EloquentModel;

class EloquentService
{
    /**
     * @var EloquentModel
     */
    protected $model;

    public function paginate(?int $limit=15,$columns = [])
    {
        return $this->model->paginate();
    }
}
