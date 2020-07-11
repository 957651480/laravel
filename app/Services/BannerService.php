<?php


namespace App\Services;


use App\Models\Banner;

class BannerService extends EloquentService
{

    /**
     * @var Banner
     */
    protected $model;

    /**
     * BannerService constructor.
     * @param Banner $model
     */
    public function __construct(Banner $model)
    {
        $this->model = $model;
    }


}
