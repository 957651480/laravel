<?php


namespace App\Repositories;


use App\Contracts\FileRepositoryInterface;
use App\Models\File;

class FileRepository extends EloquentRepository implements FileRepositoryInterface
{

    /**
     * @var File
     */
    protected $model;

    /**
     * FileRepository constructor.
     * @param File $model
     */
    public function __construct(File $model)
    {
        $this->model = $model;
    }

}
