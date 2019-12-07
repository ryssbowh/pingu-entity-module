<?php

namespace Pingu\Entity\Support;

use Pingu\Core\Support\Routes;
use Pingu\Entity\Support\Bundle;
use Pingu\Entity\Http\Controllers\AdminBundleController;

class BaseBundleRoutes extends Routes
{
    public function __construct()
    {
        $this->routes = $this->routes();
    }

    /**
     * @inheritDoc
     */
    protected function routes(): array
    {
        return [
            'admin' => ['indexFields', 'editField', 'storeField', 'patchFields', 'createField', 'updateField', 'deleteField', 'confirmDeleteField'],
            'ajax' => ['editField', 'storeField', 'patchFields', 'createField', 'updateField', 'deleteField']
        ];
    }

    /**
     * @inheritDoc
     */
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
    /**
     * Registers all the routes for an index (as found in routes()) into Laravel Route system
     * 
     * @param string $routeIndex
     */
    protected function mapEntityRoutes(string $routeIndex)
    {
        if (!isset($this->routes[$routeIndex])) {
            return;
        }

        $controller = 'Pingu\\Entity\\Http\\Controllers\\'.ucfirst($routeIndex).'BundleController';

        foreach ($this->routes[$routeIndex] as $name) {
            $path = $routeIndex.'.'.$name;
            $method = $this->routeMethods()[$name];

            $action = $controller.'@'.$name;
            $uris = \Uris::get(Bundle::class);

            \Route::$method($uris->$name(), ['uses' => $action]);
        }
    }

    /**
     * Registers all bundle routes in Laravel Route system
     */
    protected function mapBundleRoutes()
    {
        $routes = $this;
        \Route::middleware(['web', 'permission:access admin area', 'permission:manage bundles'])
            ->prefix(adminPrefix())
            ->group(
                function () use ($routes) {
                    $routes->mapEntityRoutes('admin');
                }
            );
        \Route::middleware(['ajax', 'permission:manage bundles'])
            ->prefix(ajaxPrefix())
            ->group(
                function () use ($routes) {
                    $routes->mapEntityRoutes('ajax');
                }
            );
    }

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->mapBundleRoutes();
    }
}