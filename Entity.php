<?php 

namespace Pingu\Entity;

use Pingu\Entity\Support\Entity as EntityModel;
use Pingu\Entity\Exceptions\EntityException;

class Entity
{
    /**
     * List of registered entities
     * @var array
     */
    protected $entities = [];

    /**
     * List of renderable entities
     * @var array
     */
    protected $renderableEntities = [];

    /**
     * Registers an entity
     *
     * @throws EntityException
     * 
     * @param EntityModel $entity
     */
    public function registerEntity(EntityModel $entity)
    {
        if ($this->isEntityRegistered($entity->identifier())) {
            throw EntityException::registered($entity);
        }
        $this->entities[$entity->identifier()] = get_class($entity);
        //Register entity route slug
        \ModelRoutes::registerSlugFromObject($entity);
    }

    /**
     * Checks if an entity is registered
     * 
     * @param string $name
     * 
     * @return boolean
     */
    public function isEntityRegistered(string $name): bool
    {
        return isset($this->entities[$name]);
    }

    /**
     * Checks if an entity is registered
     * 
     * @param string|object $entity
     * 
     * @return boolean
     */
    public function isEntityRenderable($entity): bool
    {
        $entity = object_to_class($entity);
        return in_array($entity, $this->renderableEntities);
    }

    /**
     * Gets a registered entity
     * 
     * @param string $name
     * 
     * @return EntityModel
     */
    public function getRegisteredEntity(string $name)
    {
        if (!$this->isEntityRegistered($name)) {
            throw EntityException::notRegistered($name);
        }
        return $this->entities[$name];
    }

    /**
     * Get all registered entities
     * 
     * @return array
     */
    public function getRegisteredEntities()
    {
        return $this->entities;
    }

    /**
     * Get all registered renderable entities
     * 
     * @return array
     */
    public function getRenderableEntities()
    {
        return $this->renderableEntities;
    }

    /**
     * Get all registered entities names
     * 
     * @return array
     */
    public function getRegisteredEntitiesNames()
    {
        return array_keys($this->entities);
    }
}