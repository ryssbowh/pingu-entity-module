<?php

namespace Pingu\Entity\Traits;

use Pingu\Core\Contracts\ActionRepositoryContract;
use Pingu\Core\Contracts\RouteContexts\RouteContextRepositoryContract;
use Pingu\Core\Support\Contexts\EntityContextRepository;
use Pingu\Core\Support\Routes;
use Pingu\Core\Traits\Models\HasActionsThroughFacade;
use Pingu\Core\Traits\Models\HasPolicy;
use Pingu\Core\Traits\Models\HasRouteSlug;
use Pingu\Core\Traits\Models\HasRoutesThroughFacade;
use Pingu\Entity\Support\Actions\BaseEntityActions;
use Pingu\Entity\Support\Routes\BaseEntityRoutes;
use Pingu\Entity\Traits\RendersEntity;

trait DefaultEntity
{
    use HasActionsThroughFacade,
        HasRoutesThroughFacade,
        HasRouteSlug,
        RendersEntity,
        HasPolicy;

    /**
     * @inheritDoc
     */
    public static function contextRepositoryClass(): RouteContextRepositoryContract
    {
        return new EntityContextRepository(static::$routeContexts);
    }

    /**
     * @inheritDoc
     */
    protected function defaultActionsInstance(): ActionRepositoryContract
    {
        return new BaseEntityActions;
    }

    /**
     * @inheritDoc
     */
    protected function defaultRouteInstance(): Routes
    {
        return new BaseEntityRoutes($this);
    }
}