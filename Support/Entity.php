<?php

namespace Pingu\Entity\Support;

use Illuminate\Support\Str;
use Pingu\Core\Contracts\HasActionsContract;
use Pingu\Core\Contracts\HasIdentifierContract;
use Pingu\Core\Contracts\HasPolicyContract;
use Pingu\Core\Contracts\HasRouteSlugContract;
use Pingu\Core\Contracts\HasRoutesContract;
use Pingu\Core\Contracts\HasUrisContract;
use Pingu\Core\Contracts\RenderableContract;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Support\{Actions, Routes, Uris};
use Pingu\Core\Traits\HasActionsThroughFacade;
use Pingu\Core\Traits\HasRoutesThroughFacade;
use Pingu\Core\Traits\HasUrisThroughFacade;
use Pingu\Core\Traits\Models\HasRouteSlug;
use Pingu\Core\Traits\RendersWithRenderer;
use Pingu\Entity\Events\RegisteredEntity;
use Pingu\Entity\Events\RegisteringEntity;
use Pingu\Entity\Facades\Entity as EntityFacade;
use Pingu\Entity\Support\Actions\BaseEntityActions;
use Pingu\Entity\Support\Forms\BaseEntityForms;
use Pingu\Entity\Support\Routes\BaseEntityRoutes;
use Pingu\Entity\Support\Uris\BaseEntityUris;
use Pingu\Entity\Traits\RendersEntity;
use Pingu\Forms\Contracts\FormRepositoryContract;
use Pingu\Forms\Traits\Models\HasForms;

abstract class Entity extends BaseModel implements
    HasActionsContract,
    HasRoutesContract,
    HasPolicyContract,
    HasUrisContract,
    HasRouteSlugContract,
    RenderableContract
{
    use HasActionsThroughFacade, 
        HasUrisThroughFacade, 
        HasRoutesThroughFacade,
        HasActionsThroughFacade,
        HasRouteSlug,
        RendersEntity;

    public $adminListFields = [];

    protected $observables = ['registering', 'registered'];

    /**
     * Register a registering model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function registering($callback)
    {
        static::registerModelEvent('registering', $callback);
    }

    /**
     * Register a registered model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function registered($callback)
    {
        static::registerModelEvent('registered', $callback);
    }

    /**
     * Forms class for this entity
     * 
     * @return EntityFormRepositoryContract
     */
    public function forms(): FormRepositoryContract
    {
        return new BaseEntityForms($this);
    }

    /**
     * Identifier for this entity, for internal use
     * 
     * @return string
     */
    public function identifier(): string
    {
        return 'entity-'.class_machine_name($this);
    }

    /**
     * @inheritDoc
     */
    public function viewIdentifier(): string
    {
        return \Str::kebab($this->identifier());
    }
    
    /**
     * @inheritDoc
     */
    public function getViewKey(): string
    {
        return $this->getKey();
    }

    /**
     * Default instance for routes
     * 
     * @return Routes
     */
    protected function defaultRouteInstance(): Routes
    {
        return new BaseEntityRoutes($this);
    }

    /**
     * Default instance for routes
     * 
     * @return Routes
     */
    protected function defaultActionsInstance(): Actions
    {
        return new BaseEntityActions($this);
    }

    /**
     * Default instance for routes
     * 
     * @return Routes
     */
    protected function defaultUrisInstance(): Uris
    {
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
        return $this->defaultRouteInstance();
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
        return $this->defaultActionsInstance();
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
        return $this->defaultUrisInstance();
    }

    /**
     * Registers this entity
     */
    public function register()
    {
        $this->fireModelEvent('registering');
        EntityFacade::registerEntity($this);
        \Uris::register(get_class($this), $this->getUrisInstance());
        \Routes::register(get_class($this), $this->getRoutesInstance());
        \Actions::register(get_class($this), $this->getActionsInstance());
        \Policies::register(get_class($this), $this->getPolicy());
        $this->fireModelEvent('registered');
    }
}