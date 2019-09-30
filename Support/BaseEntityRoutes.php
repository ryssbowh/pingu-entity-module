<?php

namespace Pingu\Entity\Support;

use Pingu\Entity\Contracts\Routes;
use Pingu\Entity\Traits\MapsEntityRoutes;

class BaseEntityRoutes extends Routes
{
    use MapsEntityRoutes;

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

    protected function routeMethods(): array
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

    protected function getRouteUri(string $name)
    {
        return $this->object->uris()->$name();
    }

    protected function getRouteParams(string $path, string $controllerAction): array
    {
        $array = ['uses' => $controllerAction, 'entity' => $this->object];
        return array_merge($this->routeParams()[$path] ?? [], $array);
    }

    protected function defaultController(string $index)
    {
        $class = $this->controllerNamespace().'\\'.class_basename(get_class($this->object)).ucfirst($index).'Controller';
        if(!class_exists($class)){
            $class = 'Pingu\\Entity\\Http\\Controllers\\'.ucfirst($index).'EntityController';
        }
        return $class;
    }

    protected function mapWebRoutes()
    {
        $routes = $this;
        $namespace = $this->controllerNamespace();
        \Route::middleware(['web', 'permission:browse site'])
            ->group(function() use ($routes){
                $routes->mapEntityRoutes('web');
            });
    }

    protected function mapAjaxRoutes()
    {
        $routes = $this;
        $namespace = $this->controllerNamespace();
        \Route::prefix(ajaxPrefix())
            ->middleware('ajax')
            ->group(function() use ($routes){
                $routes->mapEntityRoutes('ajax');
            });
    }

    protected function mapAdminRoutes()
    {
        $routes = $this;
        $namespace = $this->controllerNamespace();
        \Route::middleware(['web', 'permission:access admin area'])
            ->prefix(adminPrefix())
            ->group(function() use ($routes){
                $routes->mapEntityRoutes('admin');
            });
    }

    public function registerRoutes()
    {
        $this->mapAdminRoutes();
        $this->mapWebRoutes();
        $this->mapAjaxRoutes();
    }
}