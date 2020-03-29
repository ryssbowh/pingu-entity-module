<?php

namespace Pingu\Entity;

use Illuminate\Support\Arr;
use Pingu\Core\Contracts\HasIdentifierContract;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Support\FieldDisplay\FieldDisplay as FieldDisplayHandler;
use Pingu\Field\Exceptions\DisplayerException;

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
     * @param HasIdentifierContract $object
     * @param callable $callback
     */
    public function getCache(HasIdentifierContract $object, $callback)
    {
        if (config('entity.useCache', false)) {
            $key = 'entity.display.'.$object->identifier();
            return \ArrayCache::rememberForever($key, $callback);
        }
        return $callback();
    }

    /**
     * Registers a field display for an object
     * 
     * @param HasIdentifierContract $object
     * @param FieldLayout $layout
     */
    public function register(HasIdentifierContract $object, FieldDisplayHandler $display)
    {
        $this->fieldDisplays[$object->identifier()] = $display;
    }

    /**
     * Get a FieldLayout class for a Bundle
     * 
     * @param HasIdentifierContract $object
     * 
     * @return FieldDisplay
     */
    public function getFieldDisplay(HasIdentifierContract $object): FieldDisplayHandler
    {
        return isset($this->fieldDisplays[$object->identifier()]) ? 
            $this->fieldDisplays[$object->identifier()]->load() : 
            null;
    }

    /**
     * Forget the field display cache for an object
     * 
     * @param string|HasIdentifierContract $identifier
     */
    public function forgetCache($identifier)
    {
        if ($identifier instanceof HasIdentifierContract) {
            $identifier = $identifier->identifier();
        }
        \ArrayCache::forget('entity.display.'.$identifier);
    }
}