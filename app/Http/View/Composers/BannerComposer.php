<?php


namespace App\Http\View\Composers;


use App\Models\Banner;
use Illuminate\View\View;

class BannerComposer
{
    /**
     * @var Banner
     */
    protected $banners;

    /**
     * BannerComposer constructor.
     * @param Banner $banners
     */
    public function __construct(Banner $banners)
    {
        $this->banners = $banners;
    }


    /**
     * 将数据绑定到视图
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('banners', $this->banners->bannerList());
    }
}