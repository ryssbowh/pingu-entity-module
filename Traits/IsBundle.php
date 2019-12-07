<?php 

namespace Pingu\Entity\Traits;

use Pingu\Core\Support\Actions;
use Pingu\Core\Support\Uris;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Support\EntityBundleActions;
use Pingu\Entity\Support\EntityBundleUris;

/**
 * This traits is to be used on entities that also define a bundle, ContentType would be 
 * the perfect example, it's an entity but each of its instances is a bundle.
 */
trait IsBundle
{
    /**
     * Bundle class associated to that entity
     * 
     * @return string
     */
    public abstract static function bundleClass(): string;

    /**
     * Boots this trait.
     * Will register the bundle of that entity when created
     */
    public static function bootIsBundle()
    {
        static::created(
            function ($entity) {
                    $class = $entity::bundleClass();
                    $bundle = new $class($entity);
                    \Bundle::registerBundle($bundle);
            }
        );
    }

    /**
     * @inheritDoc
     */
    protected function getActionsInstance(): Actions
    {
        $class = base_namespace($this) . '\\Actions\\' . class_basename($this).'Actions';
        if (class_exists($class)) {
            return new $class($this);
        }
        return new EntityBundleActions($this);
    }

    /**
     * @inheritDoc
     */
    protected function getUrisInstance(): Uris
    {
        $class = base_namespace($this) . '\\Uris\\' . class_basename($this).'Uris';
        if (class_exists($class)) {
            return new $class($this);
        }
        return new EntityBundleUris($this);
    }

    /**
     * Bundle name for this entity
     *
     * @return string
     */
    abstract public function bundleName(): string;

    /**
     * Bundle getter
     *
     * @return BundleContract
     */
    public function bundle(): BundleContract
    {
        return \Bundle::get($this->bundleName());
    }
}