<?php 

namespace Pingu\Entity\Support;

use Illuminate\Database\Eloquent\Collection;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Exceptions\EntityBundleException;
use Pingu\Entity\Support\Bundle\ModelBundle;

abstract class EntityBundle extends Entity
{
    /**
     * @var ModelBundle
     */
    protected $bundleInstance;

    /**
     * Boot entity.
     * Registers bundle, create display and layout when an instance of this entity is cerated
     * Deletes layout and display when an instance of this entity is deleted
     * Registers all bundles when this entity is registered
     */
    public static function boot()
    {
        parent::boot();

        static::created(
            function ($entity) {
                $entity->toBundle()->register();
            }
        );

        static::deleting(
            function ($entity) {
                $entity->toBundle()->fields()->deleteAll();
            }
        );

        static::registered(
            function ($entity) {
                $entity->registerAllBundles();
            }
        );
    }

    /**
     * Bundle class associated to this entity
     * 
     * @return string
     */
    abstract function bundleClass(): string;

    /**
     * Get all the entities that should be registred as bundle
     * 
     * @return Collection
     */
    protected function getEntitiesToRegisterAsBundles(): Collection
    {
        return $this::all();
    }

    /**
     * Bundle associated to this entity
     * 
     * @return ModelBundle
     */
    public function toBundle(): ModelBundle
    {
        if (!$this->exists) {
            throw EntityBundleException::fromEntity($this);
        }
        if (!$this->bundleInstance) {
            $class = $this->bundleClass();
            $this->bundleInstance = new $class($this);
        }
        return $this->bundleInstance;
    }

    /**
     * Register all bundles
     */
    public function registerAllBundles()
    {
        if (\Schema::hasTable($this->getTable())) {
            foreach ($this->getEntitiesToRegisterAsBundles() as $entity) {
                \Bundle::registerBundle($entity->toBundle());
            }
        }
    }
}