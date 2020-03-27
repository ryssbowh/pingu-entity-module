<?php

namespace Pingu\Entity;

use Illuminate\Support\Arr;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Support\FieldLayout\FieldLayout as FieldLayoutHandler;

class FieldLayout
{
     /**
     * List of registered form layouts
     * @var array
     */
    protected $formLayouts = [];
    
    /**
     * Registers a form layout for a class
     * 
     * @param string      $slug   class name
     * @param FieldLayoutHandler $layout
     */
    public function register(string $slug, FieldLayoutHandler $layout)
    {
        $this->formLayouts[$slug] = $layout;
    }

    /**
     * Get a FormLayout class for an Entity
     * 
     * @param Entity $entity
     * 
     * @return FieldLayoutHandler
     */
    public function getEntityFormLayout(Entity $entity): FieldLayoutHandler
    {
        $object = get_class($entity);
        return isset($this->formLayouts[$object]) ? $this->formLayouts[$object]->load() : null;
    }

    /**
     * Get a FormLayout class for a Bundle
     * 
     * @param BundleContract $bundle
     * 
     * @return FieldLayoutHandler
     */
    public function getBundleFormLayout(BundleContract $bundle): FieldLayoutHandler
    {
        $object = $bundle->bundleName();
        return isset($this->formLayouts[$object]) ? $this->formLayouts[$object]->load() : null;
    }

    /**
     * Load or save an object form layout
     * 
     * @param string   $object
     * @param callable $callback
     */
    public function getCache(string $object, $callback)
    {
        if (config('entity.useCache', false)) {
            $key = 'entity.layout.'.$object;
            return \ArrayCache::rememberForever($key, $callback);
        }
        return $callback();
    }

    /**
     * Forget the form layout cache for an object
     * 
     * @param string $object
     */
    public function forgetCache(string $object)
    {
        \ArrayCache::forget('entity.layout.'.$object);
    }
}