<?php


namespace App\Contracts;


interface FileRepositoryInterface extends EloquentRepositoryInterface
{


    public function list();
}
