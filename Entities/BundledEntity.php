<?php

namespace Pingu\Entity\Entities;

use Pingu\Core\Support\Uris;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Support\BundledEntityUris;
use Pingu\Field\Support\FieldLayout;
use Pingu\Field\Support\FieldLayoutBundled;
use Pingu\Field\Traits\HasBundleFields;

abstract class BundledEntity extends Entity
{
    use HasBundleFields;

    protected $bundle;
    
    /**
     * Bundle name getter
     * 
     * @return string
     */
    abstract public function bundleName(): ?string;

    public function setBundle(BundleContract $bundle)
    {
        $this->bundle = $bundle;
        $this->fields()->setBundle($bundle);
        $this->fillable($this->getFillable());
        $this->registerFormLayout();
    }
    
    /**
     * Bundle getter
     * 
     * @return ?BundleContract
     */
    public function bundle(): ?BundleContract
    {
        if ($this->bundle) {
            return $this->bundle;
        }
        if ($name = $this->bundleName()) {
            return \Bundle::get($name);
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

    /**
     * @inheritDoc
     */
    protected function fieldLayoutInstance(): FieldLayout
    {
        return new FieldLayoutBundled($this);
    }
}