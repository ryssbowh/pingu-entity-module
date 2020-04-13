<?php

namespace Pingu\Entity\Support\Bundle;

use Illuminate\Support\Collection;
use Pingu\Core\Support\Actions;
use Pingu\Core\Support\Routes;
use Pingu\Core\Support\Uris;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Support\Actions\BaseBundleActions;
use Pingu\Entity\Support\Entity;
use Pingu\Entity\Support\Routes\BaseBundleRoutes;
use Pingu\Entity\Support\Uris\BaseBundleUris;
use Pingu\Entity\Traits\Bundle;

abstract class ModelBundle implements BundleContract
{
    use Bundle;

    protected $entity;

    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * Entity that defines the bundle
     * 
     * @return string
     */
    public abstract static function entityClass(): string;

    /**
     * Get the entity attached to this bundle
     * 
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Registers this bundle
     */
    public function register()
    {
        \Bundle::registerBundle($this);
    }

    /**
     * @inheritDoc
     */
    public static function allBundles(): Collection
    {
        return static::entityClass()::all()->map(function ($entity) {
            return new static($entity);
        });
    }
}