<?php

namespace Pingu\Entity\Entities;

use Illuminate\Support\Str;
use Pingu\Core\Contracts\HasActionsContract;
use Pingu\Core\Contracts\HasRouteSlugContract;
use Pingu\Core\Contracts\HasUrisContract;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Support\Accessor;
use Pingu\Core\Support\Actions;
use Pingu\Core\Support\Routes;
use Pingu\Core\Support\Uris;
use Pingu\Core\Traits\HasActionsThroughFacade;
use Pingu\Core\Traits\HasRoutesThroughFacade;
use Pingu\Core\Traits\HasUrisThroughFacade;
use Pingu\Entity\Facades\Entity as EntityFacade;
use Pingu\Entity\Support\BaseEntityActions;
use Pingu\Entity\Support\BaseEntityRoutes;
use Pingu\Entity\Support\BaseEntityUris;

abstract class Entity extends BaseModel implements 
    HasRouteSlugContract,
    HasUrisContract,
    HasActionsContract
{
    use HasActionsThroughFacade, 
        HasUrisThroughFacade, 
        HasRoutesThroughFacade,
        HasActionsThroughFacade;

    public $adminListFields = [];

    protected $routes;

    /**
     * @inheritDoc
     */
    abstract public function getPolicy(): string;

    /**
     * Entity machine name
     * 
     * @return string
     */
    public function entityType(): string
    {
        return class_machine_name($this);
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
        return new BaseEntityUris($this);
    }

    /**
     * Routes instance for this entity
     * 
     * @return Routes
     */
    protected function getRoutesInstance(): Routes
    {
        $class = base_namespace($this) . '\\Routes\\' . class_basename($this).'Routes';
        if (class_exists($class)) {
            return new $class($this);
        }
        return new BaseEntityRoutes($this);
    }
    
    /**
     * Actions instance for this entity
     * 
     * @return Actions
     */
    protected function getActionsInstance(): Actions
    {
        $class = base_namespace($this) . '\\Actions\\' . class_basename($this).'Actions';
        if (class_exists($class)) {
            return new $class($this);
        }
        return new BaseEntityActions($this);
    }

    /**
     * Registers this entity
     */
    public function register()
    {
        EntityFacade::registerEntity($this);
        \Uris::register(get_class($this), $this->getUrisInstance());
        \Routes::register(get_class($this), $this->getRoutesInstance());
        \Actions::register(get_class($this), $this->getActionsInstance());
        \Policies::register(get_class($this), $this->getPolicy());
    }
}