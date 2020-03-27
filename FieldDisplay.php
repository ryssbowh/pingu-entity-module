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
     * Load or save an object form layout
     * 
     * @param string   $object
     * @param callable $callback
     */
    public function getCache(string $object, $callback)
    {
        if (config('entity.useCache', false)) {
            $key = 'entity.display.'.$object;
            return \ArrayCache::rememberForever($key, $callback);
        }
        return $callback();
    }

    /**
     * Registers a form layout for a class
     * 
     * @param string      $slug   class name
     * @param FieldLayout $layout
     */
    public function register(string $slug, FieldDisplayHandler $display)
    {
        $this->fieldDisplays[$slug] = $display;
    }

    /**
     * Get a FormLayout class for a Bundle
     * 
     * @param BundleContract $bundle
     * 
     * @return FieldDisplay
     */
    public function getBundleDisplay(BundleContract $bundle): FieldDisplayHandler
    {
        $object = $bundle->bundleName();
        return isset($this->fieldDisplays[$object]) ? $this->fieldDisplays[$object]->load() : null;
    }

    /**
     * Forget the form layout cache for an object
     * 
     * @param string $object
     */
    public function forgetCache(string $object)
    {
        \ArrayCache::forget('entity.display.'.$object);
    }
}