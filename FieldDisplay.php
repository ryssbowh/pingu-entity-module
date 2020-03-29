<?php

namespace Pingu\Entity;

use Illuminate\Support\Arr;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Exceptions\DisplayerException;
use Pingu\Entity\Support\FieldDisplay\FieldDisplay as FieldDisplayHandler;

class FieldDisplay
{
    /**
     * List of registered field displays
     * @var array
     */
    protected $fieldDisplays = [];

    /**
     * Get an object field display cache
     * 
     * @param string   $identifier
     * @param callable $callback
     */
    public function getCache(string $identifier, $callback)
    {
        if (config('entity.useCache', false)) {
            $key = 'entity.display.'.$identifier;
            return \ArrayCache::rememberForever($key, $callback);
        }
        return $callback();
    }

    /**
     * Registers a field display for a class
     * 
     * @param string      $identifier
     * @param FieldLayout $layout
     */
    public function register(string $identifier, FieldDisplayHandler $display)
    {
        $this->fieldDisplays[$identifier] = $display;
    }

    /**
     * Get a FieldLayout class for a Bundle
     * 
     * @param BundleContract $bundle
     * 
     * @return FieldDisplay
     */
    public function getFieldDisplay(string $identifier): FieldDisplayHandler
    {
        return isset($this->fieldDisplays[$identifier]) ? $this->fieldDisplays[$identifier]->load() : null;
    }

    /**
     * Forget the field display cache for an object
     * 
     * @param string $identifier
     */
    public function forgetCache(string $identifier)
    {
        \ArrayCache::forget('entity.display.'.$identifier);
    }
}