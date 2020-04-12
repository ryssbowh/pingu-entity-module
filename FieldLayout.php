<?php

namespace Pingu\Entity;

use Illuminate\Support\Arr;
use Pingu\Core\Contracts\HasIdentifierContract;
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
     * @param HasIdentifierContract $object
     * @param FieldLayoutHandler $layout
     */
    public function register(HasIdentifierContract $object, FieldLayoutHandler $layout)
    {
        $this->fieldLayouts[$object->identifier()] = $layout;
    }

    /**
     * Get a FormLayout class for an object
     * 
     * @param HasIdentifierContract $object
     * 
     * @return FieldLayoutHandler
     */
    public function getFieldLayout(HasIdentifierContract $object): FieldLayoutHandler
    {
        return isset($this->fieldLayouts[$object->identifier()]) ? 
            $this->fieldLayouts[$object->identifier()]->load() : 
            null;
    }

    /**
     * Get field layout cache for an object
     * 
     * @param HasIdentifierContract $object
     * @param Callable $callback
     */
    public function getCache(HasIdentifierContract $object, $callback)
    {
        if (config('entity.useCache', false)) {
            $key = config('entity.cache-keys.layout').'.'.$object->identifier();
            return \ArrayCache::rememberForever($key, $callback);
        }
        return $callback();
    }

    /**
     * Forget the field layout cache for an object
     * 
     * @param string|HasIdentifierContract $identifier
     */
    public function forgetCache($identifier)
    {
        if ($identifier instanceof HasIdentifierContract) {
            $identifier = $identifier->identifier();
        }
        \ArrayCache::forget(config('entity.cache-keys.layout').'.'.$identifier);
    }
}