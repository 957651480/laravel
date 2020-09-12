<?php

namespace App\Observers;

use App\Models\ExcavatorCost;

class ExcavatorCostObserver
{


    /**
     * Handle the category "created" event.
     *
     * @param  \App\Models\ExcavatorCost  $category
     * @return void
     */
    public function created(ExcavatorCost $category)
    {
        //
        $category->flushCacheKey();
    }

    /**
     * Handle the category "updated" event.
     *
     * @param  \App\Models\ExcavatorCost  $category
     * @return void
     */
    public function updated(ExcavatorCost $category)
    {
        //
        $category->flushCacheKey();
    }

    /**
     * Handle the category "deleted" event.
     *
     * @param  \App\Models\ExcavatorCost  $category
     * @return void
     */
    public function deleted(ExcavatorCost $category)
    {
        //
        $category->flushCacheKey();
    }

    /**
     * Handle the category "restored" event.
     *
     * @param  \App\Models\ExcavatorCost  $category
     * @return void
     */
    public function restored(ExcavatorCost $category)
    {
        //
    }

    /**
     * Handle the category "force deleted" event.
     *
     * @param  \App\Models\ExcavatorCost  $category
     * @return void
     */
    public function forceDeleted(ExcavatorCost $category)
    {
        //
    }
}
