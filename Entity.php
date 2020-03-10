<?php 

namespace Pingu\Entity;

use Pingu\Entity\Entities\Entity as EntityModel;
use Pingu\Entity\Exceptions\EntityException;

class Entity
{
   
    protected $entities = [];
    protected $uris = [];

    /**
     * Registers an entity
     *
     * @throws EntityException
     * 
     * @param EntityModel $entity
     */
    public function registerEntity(EntityModel $entity)
    {
        if ($this->isEntityRegistered($entity->entityType())) {
            throw EntityException::registered($entity);
        }
        $this->entities[$entity->entityType()] = $entity;
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
}