<?php 

namespace Pingu\Entity\Traits;

use Pingu\Core\Support\Routes;
use Pingu\Core\Support\Uris;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Support\BundledEntityRoutes;
use Pingu\Entity\Support\BundledEntityUris;
use Pingu\Field\Support\FieldLayoutBundled;
use Pingu\Field\Traits\HasBundleFields;

/**
 * This trait is to be used on entities that have a bundle
 */
trait IsBundled
{
    use HasBundleFields;

    protected $bundle;
    
    /**
     * Bundle name getter
     * 
     * @return string
     */
    abstract public function bundleName(): string;

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
    protected function registerFormLayout()
    {
        if ($bundle = $this->bundleName()) {
            \Field::registerFormLayout($bundle, new FieldLayoutBundled($this));
        }
    }

    /**
     * @inheritDoc
     */
    public static function formLayout()
    {
        return \Field::getFormLayout((new static)->bundleName());
    }
}