<?php


namespace App\Cache;


class SysTreeCache extends Cache
{

    public function get()
    {
        $this->cache->get('');
    }
}