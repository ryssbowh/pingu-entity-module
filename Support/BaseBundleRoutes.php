<?php

namespace Pingu\Entity\Support;

use Pingu\Core\Support\Routes;
use Pingu\Entity\Http\Controllers\AdminBundleController;
use Pingu\Entity\Http\Controllers\AdminFormLayoutController;
use Pingu\Entity\Http\Controllers\AjaxFormLayoutController;
use Pingu\Entity\Support\Bundle;

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
            'admin' => ['indexFields', 'editField', 'storeField', 'createField', 'updateField', 'deleteField', 'confirmDeleteField', 'formLayout'],
            'ajax' => ['editField', 'storeField', 'createField', 'updateField', 'deleteField', 'patchFormLayout']
        ];
    }

    /**
     * @inheritDoc
     */
    protected function routeMethods(): array
    {
        return [
            'storeField' => 'post',
            'updateField' => 'put',
            'deleteField' => 'delete',
            'patchFormLayout' => 'patch'
        ];
    }

    /**
     * @inheritDoc
     */
    protected function controllers(): array
    {
        return [
            'admin.formLayout' => AdminFormLayoutController::class.'@indexBundle',
            'ajax.patchFormLayout' => AjaxFormLayoutController::class.'@patch',
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

        $uris = \Uris::get(Bundle::class);
        $defaultController = 'Pingu\\Entity\\Http\\Controllers\\'.ucfirst($routeIndex).'BundleController';

        foreach ($this->routes[$routeIndex] as $name) {
            $path = $routeIndex.'.'.$name;

            $method = $this->routeMethods()[$name] ?? 'get';
            $controller = $this->controllers()[$path] ?? $defaultController;
 
            if (!strpos($controller, '@')) {
                $controller .= '@'.$name;
            }

            \Route::$method($uris->get($name), ['uses' => $controller]);
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