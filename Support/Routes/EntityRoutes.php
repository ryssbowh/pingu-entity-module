<?php

namespace Pingu\Entity\Support\Routes;

use Pingu\Core\Support\Routes;
use Pingu\Entity\Traits\MapsEntityRoutes;

/**
 * This class defines all the routes, names, middlewares and methods for every entity.
 * This Route class does NOT register any routes in Laravel.
 *
 * Its purpose is not to be extended, all the attributes here will be re-used in the BaseEntityRoutes class.
 * 
 */
class EntityRoutes extends Routes
{
    /**
     * @inheritDoc
     */
    protected function routes(): array
    {
        return [
            'admin' => [
                'index', 'create', 'store', 'edit', 'update', 'patch', 'confirmDelete', 'delete'
            ],
            'ajax' => [
                'index', 'view', 'create', 'store', 'edit', 'update', 'patch', 'delete'
            ],
            'web' => [
                'view'
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    protected function controllerActions(): array
    {
        return [
            'confirmDelete' => 'delete'
        ];
    }

    /**
     * @inheritDoc
     */
    protected function methods(): array
    {
        return [
            'store' => 'post',
            'update' => 'put',
            'patch' => 'patch',
            'delete' => 'delete',
        ];
    }

    /**
     * @inheritDoc
     */
    protected function middlewares(): array
    {
        return [
            'view' => 'can:view,@slug',
            'index' => 'can:index,@class',
            'create' => 'can:create,@class',
            'store' => 'can:create,@class',
            'edit' => 'can:edit,@slug',
            'update' => 'can:edit,@slug',
            'patch' => 'can:edit,@class',
            'confirmDelete' => 'can:delete,@slug',
            'delete' => 'can:delete,@slug'
        ];
    }

    /**
     * @inheritDoc
     */
    protected function contexts(): array
    {
        return [
            'admin.confirmDelete' => ['admin-delete', 'delete']
        ];
    }

    /**
     * @inheritDoc
     */
    public function register()
    {
    }
}