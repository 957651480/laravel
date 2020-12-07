<?php


namespace App\Cache;


use Illuminate\Contracts\Cache\Repository;

abstract class Cache
{
    const PRE='com';
    const CLN=':';
    /**
     * @var Repository
     */
    protected $cache;

    /**
     * Cache constructor.
     * @param Repository $cache
     */
    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }


}
