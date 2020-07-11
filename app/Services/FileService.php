<?php


namespace App\Services;


use App\Models\File;
use Arr;
use Illuminate\Http\UploadedFile;

class FileService extends EloquentService
{

    /**
     * @var File
     */
   protected $model;

    /**
     * FileService constructor.
     * @param File $model
     */
    public function __construct(File $model)
    {
        $this->model = $model;
    }


    public function list(array $parameters = [])
    {
        return $this->model->paginate(Arr::get($parameters,'limit'),Arr::get($parameters,'columns',['*']));
    }



    public function upload(UploadedFile $uploadedFile)
    {
        $path = $uploadedFile->storePublicly(date('Y/m/d'));
        $file = $this->model->create([
           'path'=>$path,
           'extension'=>$uploadedFile->extension(),
           'mime_type'=>$uploadedFile->getMimeType(),
           'name'=>$uploadedFile->getClientOriginalName(),
           'size'=>$uploadedFile->getSize(),
        ]);
        return $file;
    }
}
