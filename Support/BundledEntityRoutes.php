<?php

namespace Pingu\Entity\Support;

class BundledEntityRoutes extends BaseEntityRoutes
{
    protected function getBaseEntityMiddlewares()
    {
        $middlewares = $this->baseEntityRoutes->getMiddlewares();
        $middlewares['create'] = 'can:create,@class,bundle';
        $middlewares['store'] = 'can:create,@class,bundle';
        return $middlewares;
    }
}