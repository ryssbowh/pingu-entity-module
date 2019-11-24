<?php 

namespace Pingu\Entity\Traits;

use Pingu\Core\Support\Uris;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Support\BundledEntityUris;
use Pingu\Field\Traits\HasBundleFields;

/**
 * This trait is to be used on entities that have a bundle
 */
trait IsBundled
{
    use HasBundleFields;
    
    /**
     * Bundle name getter
     * 
     * @return string
     */
    abstract public function bundleName(): string;
    
    /**
     * Bundle getter
     * 
     * @return ?BundleContract
     */
    public function bundle(): ?BundleContract
    {
        if ($name = $this->bundleName()) {
            return \Bundle::get($this->bundleName());
        }
        return null;
    }

    /**
     * Uris instance for this entity
     * 
     * @return Uris
     */
    protected function getUrisInstance(): Uris
    {
        $class = base_namespace($this) . '\\Uris\\' . class_basename($this).'Uris';
        if (class_exists($class)) {
            return new $class($this);
        }
        return new BundledEntityUris($this);
    }
}