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
     * Registers an entity
     *
     * @throws EntityException
     * 
     * @param EntityModel $entity
     */
    public function registerEntity(EntityModel $entity)
    {
        if ($this->isRegistered($entity->identifier())) {
            throw EntityException::registered($entity);
        }
        $this->entities[$entity->identifier()] = get_class($entity);
    }

    /**
     * Checks if an entity is registered
     * 
     * @param string $name
     * 
     * @return boolean
     */
    public function isRegistered(string $name): bool
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
    public function get(string $name)
    {
        if (!$this->isRegistered($name)) {
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
     * Get all registered entities names
     * 
     * @return array
     */
    public function getRegisteredEntitiesNames()
    {
        return array_keys($this->entities);
    }
}