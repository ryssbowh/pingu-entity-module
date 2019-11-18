<?php

namespace Pingu\Entity\Support;

use Pingu\Core\Support\Routes;
use Pingu\Entity\Traits\MapsEntityRoutes;

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
                'index', 'view', 'create', 'store', 'edit', 'update', 'patch', 'confirmDelete', 'delete'
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    protected function methods(): array
    {
        return [
            'index' => 'get',
            'view' => 'get',
            'create' => 'get',
            'store' => 'post',
            'edit' => 'get',
            'update' => 'put',
            'patch' => 'patch',
            'confirmDelete' => 'get',
            'delete' => 'delete'
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
            'patch' => 'can:edit,@slug',
            'confirmDelete' => 'can:delete,@slug',
            'delete' => 'can:delete,@slug'
        ];
    }

    /**
     * @inheritDoc
     */
    public function register()
    {
    }
}