<?php


namespace App\Services;


use App\Contracts\FileRepositoryInterface;

class FileService
{

    /**
     * @var FileRepositoryInterface
     */
   protected $repository;

    /**
     * FileService constructor.
     * @param FileRepositoryInterface $repository
     */
    public function __construct(FileRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    public function list()
    {
        return $this->repository->list();
    }
}
