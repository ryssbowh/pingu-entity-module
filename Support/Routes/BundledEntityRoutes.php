<?php

namespace Pingu\Entity\Support\Routes;

class BundledEntityRoutes extends BaseEntityRoutes
{
    protected function getBaseEntityMiddlewares()
    {
        $middlewares = $this->baseEntityRoutes->getMiddleware();
        $middlewares['create'] = 'can:create,@class,bundle';
        $middlewares['store'] = 'can:create,@class,bundle';
        return $middlewares;
    }
}