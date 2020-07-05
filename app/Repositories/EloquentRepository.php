<?php


namespace App\Repositories;


use App\Contracts\EloquentRepositoryInterface;
use App\Models\Eloquent;

class EloquentRepository implements EloquentRepositoryInterface
{

    /**
     * @var Eloquent
     */
    protected $model;


}
