<?php

namespace App\Providers;

use App\Contracts\EloquentRepositoryInterface;
use App\Contracts\FileRepositoryInterface;
use App\Models\Banner;
use App\Observers\BannerObserver;
use App\Repositories\EloquentRepository;
use App\Repositories\FileRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{


    public $bindings = [
        EloquentRepositoryInterface::class=>EloquentRepository::class,
        FileRepositoryInterface::class=>FileRepository::class
    ];

    /**
     * @var array
     */
    public $singletons = [
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Banner::observe(BannerObserver::class);
    }
}
