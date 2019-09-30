<?php

namespace Pingu\Entity\Support;

use Pingu\Entity\Contracts\Routes;
use Pingu\Entity\Http\Controllers\AdminBundleController;
use Pingu\Entity\Traits\MapsEntityRoutes;

class BaseBundleRoutes extends Routes
{
    use MapsEntityRoutes;

    protected function routes(): array
    {
        return [
            'admin' => ['indexFields', 'editField', 'storeField', 'patchFields', 'createField', 'updateField', 'deleteField', 'confirmDeleteField'],
            'ajax' => ['editField', 'storeField', 'patchFields', 'createField', 'updateField', 'deleteField']
        ];
    }

    protected function routeMethods(): array
    {
        return [
            'indexFields' => 'get',
            'editField' => 'get',
            'storeField' => 'post',
            'patchFields' => 'patch',
            'createField' => 'get',
            'updateField' => 'put',
            'confirmDeleteField' => 'get',
            'deleteField' => 'delete'
        ];
    }

    protected function getRouteUri(string $name)
    {
        return $this->object->bundleUris()->$name();
    }

    protected function defaultController(string $index)
    {
        $class = $this->controllerNamespace().'\\'.class_basename(get_class($this->object)).ucfirst($index).'BundleController';
        if(!class_exists($class)){
            $class = 'Pingu\\Entity\\Http\\Controllers\\'.ucfirst($index).'BundleController';
        }
        return $class;
    }

    protected function getRouteParams(string $path, string $controllerAction): array
    {
        $array = ['uses' => $controllerAction, 'bundle' => $this->object];
        return array_merge($this->routeParams()[$path] ?? [], $array);
    }

    protected function mapBundleRoutes()
    {
        $routes = $this;
        \Route::middleware(['web', 'permission:access admin area', 'permission:manage bundles'])
            ->prefix(adminPrefix())
            ->group(function() use ($routes){
                $routes->mapEntityRoutes('admin');
            });
        \Route::middleware(['ajax', 'permission:manage bundles'])
            ->prefix(ajaxPrefix())
            ->group(function() use ($routes){
                $routes->mapEntityRoutes('ajax');
            });
    }

    public function registerRoutes()
    {
        $this->mapBundleRoutes();
    }
}