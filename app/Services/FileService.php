<?php


namespace App\Services;


use App\Contracts\FileRepositoryInterface;
use Illuminate\Http\UploadedFile;

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
        return $this->repository->all();
    }




    public function upload(UploadedFile $uploadedFile)
    {
        $path = $uploadedFile->storePublicly(date('Y/m/d'));
        $file = $this->repository->create([
           'path'=>$path,
           'extension'=>$uploadedFile->extension(),
           'mime_type'=>$uploadedFile->getMimeType(),
           'name'=>$uploadedFile->getClientOriginalName(),
           'size'=>$uploadedFile->getSize(),
        ]);
        return $file;
    }
}
