<?php

/**
 * Class CacheController
 */
class CacheController extends ControllerBase
{
    public function clearAction()
    {
        $this->view->disable();

        // Delete all items from the cache
        foreach ($this->cache->queryKeys() as $key) {
            $this->cache->delete($key);
        }

        die('Cache cleared');
    }
}