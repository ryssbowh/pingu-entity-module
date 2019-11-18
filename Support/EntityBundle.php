<?php

namespace Pingu\Entity\Support;

use Pingu\Core\Support\Actions;
use Pingu\Core\Support\Uris;
use Pingu\Entity\Entities\Entity;

/**
 * This class defines an bundle that is attached to an entity.
 * Example : Each content type (article, blog) is an entity, but also a bundle.
 * Having this class allows us to have the entity class separated from the bundle class.
 */
abstract class EntityBundle extends Bundle
{
    protected $entity;

    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * What entity is this bundle attached to
     *
     * @return string
     */
    abstract public static function entityClass(): string;

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
     * Actions instance for this bundle, will return the entity Actions instance
     * 
     * @return Actions
     */
    public static function actions(): Actions
    {
        return \Actions::get(static::entityClass());
    }

    /**
     * Uris instance for this bundle, will return the entity Uris instance
     * 
     * @return Actions
     */
    public static function uris(): Uris
    {
        return \Uris::get(static::entityClass());
    }

    /**
     * @inheritDoc
     */
    public function bundleName(): string
    {
        return $this->entity->bundleName();
    }

    /**
     * @inheritDoc
     */
    public function getRouteKey(): string
    {
        return $this->entity->bundleName();
    }

    /**
     * Registers one bundle for each of the existing entities
     */
    public static function registerAll()
    {
        $class = static::entityClass();
        $entity = new $class;

        if (\Schema::hasTable($entity->getTable())) {
            foreach ($entity::all() as $entity) {
                $bundle = new static($entity);
                $bundle->register();
            }
        }
    }
}