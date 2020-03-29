<?php

namespace Pingu\Entity\Support\Routes;

use Pingu\Core\Support\Routes;
use Pingu\Entity\Http\Controllers\AdminFieldDisplayController;
use Pingu\Entity\Http\Controllers\AdminFieldLayoutController;
use Pingu\Entity\Http\Controllers\AjaxFieldDisplayController;
use Pingu\Entity\Http\Controllers\AjaxFieldLayoutController;
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
            'admin' => ['indexFields', 'editField', 'storeField', 'createField', 'updateField', 'deleteField', 'confirmDeleteField', 'fieldLayout', 'fieldDisplay'],
            'ajax' => ['editField', 'storeField', 'createField', 'updateField', 'deleteField', 'patchFieldLayout', 'patchFieldDisplay']
        ];
    }

    /**
     * @inheritDoc
     */
    protected function middlewares(): array
    {
        return [
            'indexFields' => 'can:indexFields,@slug',
            'editField' => 'can:editFields,@slug',
            'storeField' => 'can:createFields,@slug',
            'createField' => 'can:createFields,@slug',
            'updateField' => 'can:editFields,@slug',
            'deleteField' => 'can:editFields,@slug',
            'confirmDeleteField' => 'can:deleteFields,@slug',
            'fieldLayout' => 'can:fieldLayout,@slug',
            'fieldDisplay' => 'can:fieldDisplay,@slug'
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
            'patchFieldLayout' => 'patch',
            'patchFieldDisplay' => 'patch',
        ];
    }

    /**
     * @inheritDoc
     */
    protected function controllers(): array
    {
        return [
            'admin.fieldLayout' => AdminFieldLayoutController::class.'@index',
            'admin.fieldDisplay' => AdminFieldDisplayController::class.'@index',
            'ajax.patchFieldLayout' => AjaxFieldLayoutController::class.'@patch',
            'ajax.patchFieldDisplay' => AjaxFieldDisplayController::class.'@patch',
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