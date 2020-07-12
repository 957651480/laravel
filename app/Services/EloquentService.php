<?php


namespace App\Services;


use App\Models\EloquentModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentService
{
    /**
     * @var EloquentModel
     */
    protected $model;

    public function create($attributes)
    {
        return $this->model->create($attributes);
    }

    public function firstModelById(int $id,$columns = ['*'],$with=[])
    {
        return $this->model->when($with,function (EloquentModel $model,$with){
            $model->with($with);
        })->whereKey($id)->first($columns);
    }


    public function delete(int $id)
    {
        $model = $this->firstModelByIdOrFail($id);
        return $model->delete();
    }

    public function batchDelete(array $ids)
    {
        return $this->model->whereIn('id',$ids)->delete();
    }

    public function firstModelByIdOrFail(int $id,$columns = ['*'],$with=[])
    {
        $model = $this->firstModelById($id,$columns,$with);
        throw_unless($model,ModelNotFoundException::class);
        return $model;
    }
}
