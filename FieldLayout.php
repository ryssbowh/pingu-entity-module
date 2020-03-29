<?php

namespace Pingu\Entity;

use Illuminate\Support\Arr;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Support\FieldLayout\FieldLayout as FieldLayoutHandler;

class FieldLayout
{
     /**
     * List of registered field layouts
     * @var array
     */
    protected $fieldLayouts = [];
    
    /**
     * Registers a form layout for a class
     * 
     * @param string      $identifier
     * @param FieldLayoutHandler $layout
     */
    public function register(string $identifier, FieldLayoutHandler $layout)
    {
        $this->fieldLayouts[$identifier] = $layout;
    }

    /**
     * Get a FormLayout class for an object
     * 
     * @param string $identifier
     * 
     * @return FieldLayoutHandler
     */
    public function getFieldLayout(string $identifier): FieldLayoutHandler
    {
        return isset($this->fieldLayouts[$identifier]) ? $this->fieldLayouts[$identifier]->load() : null;
    }

    /**
     * Get field layout cache for an object
     * 
     * @param string   $identifier
     * @param callable $callback
     */
    public function getCache(string $identifier, $callback)
    {
        if (config('entity.useCache', false)) {
            $key = 'entity.layout.'.$identifier;
            return \ArrayCache::rememberForever($key, $callback);
        }
        return $callback();
    }

    /**
     * Forget the field layout cache for an object
     * 
     * @param string $identifier
     */
    public function forgetCache(string $identifier)
    {
        \ArrayCache::forget('entity.layout.'.$identifier);
    }
}