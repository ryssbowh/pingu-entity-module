<?php

namespace Pingu\Entity\Entities;

use Pingu\Core\Support\Routes;
use Pingu\Core\Support\Uris;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Support\BundledEntityForms;
use Pingu\Entity\Support\BundledEntityUris;
use Pingu\Entity\Support\FieldDisplay\FieldDisplay;
use Pingu\Entity\Support\FieldLayout\FieldLayout;
use Pingu\Entity\Support\Routes\BundledEntityRoutes;
use Pingu\Field\Traits\HasBundleFields;
use Pingu\Forms\Contracts\FormRepositoryContract;

abstract class BundledEntity extends Entity
{
    use HasBundleFields;

    /**
     * @var ?BundleContract
     */
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
        $this->fillable($this->getFillable());
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

    protected function defaultRouteInstance(): Routes
    {
        return new BundledEntityRoutes($this);
    }

    /**
     * @inheritDoc
     */
    public function forms(): FormRepositoryContract
    {
        return new BundledEntityForms($this);
    }

    /**
     * Get field layout instance from Field facade
    */
    public function fieldLayout(): FieldLayout
    {
        return $this->bundle()->fieldLayout();
    }

    /**
     * Get field display instance from Field facade
    */
    public function fieldDisplay(): FieldDisplay
    {
        return $this->bundle()->fieldDisplay();
    }
}