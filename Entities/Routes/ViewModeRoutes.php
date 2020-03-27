<?php

namespace Pingu\Entity\Entities\Routes;

use Pingu\Entity\Support\Routes\BaseEntityRoutes;

class ViewModeRoutes extends BaseEntityRoutes
{
    protected $inheritsEntityRoutes = false;

    /**
     * @inheritDoc
     */
    protected function routes(): array
    {
        return [
            'admin' => [
                'index', 'create', 'store', 'patch', 'confirmDelete', 'delete'
            ],
            'ajax' => [
                'create', 'store', 'patch', 'delete', 'edit', 'update'
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    protected function methods(): array
    {
        return [
            'store' => 'post',
            'patch' => 'patch',
            'delete' => 'delete',
            'update' => 'put'
        ];
    }

    /**
     * @inheritDoc
     */
    protected function middlewares(): array
    {
        return [
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
}