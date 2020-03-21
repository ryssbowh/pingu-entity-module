<?php

namespace Pingu\Entity\Support;

use Illuminate\Support\Arr;
use Pingu\Core\Contracts\HasUrisContract;
use Pingu\Core\Support\Routes;
use Pingu\Entity\Entities\Entity;
use Pingu\Entity\Support\EntityRoutes;

class BaseEntityRoutes extends Routes
{
    protected $object;

    /**
     * Route class for Entity
     * @var EntityRoutes
     */
    protected $baseEntityRoutes;

    /**
     * Constructor. Will merge the routes, methods, middlewares, names and controllers
     * from the base entity routes which can be overriden by extended classes
     * 
     * @param HasUrisContract $object
     */
    public function __construct(HasUrisContract $object)
    {
        $this->object = $object;
        $this->baseEntityRoutes = \Routes::get(Entity::class);
        $this->routes = array_merge_recursive($this->baseEntityRoutes->getRoutes(), $this->routes());
        $this->methods = array_merge($this->baseEntityRoutes->getMethods(), $this->methods());
        $this->middlewares = $this->mergeMiddlewares($this->getBaseEntityMiddlewares());
        $this->names = array_merge($this->baseEntityRoutes->getNames(), $this->names());
        $this->controllers = array_merge($this->baseEntityRoutes->getControllers(), $this->controllers());
    }

    protected function getBaseEntityMiddlewares()
    {
        return $this->baseEntityRoutes->getMiddlewares();
    }

    /**
     * Merge this class definition middlewares with the base entity middlewares
     * 
     * @param array $baseMiddlewares
     * 
     * @return array
     */
    protected function mergeMiddlewares(array $baseMiddlewares): array
    {
        $middlewares = [];
        foreach ($baseMiddlewares as $index => $baseMiddleware) {
            $middlewares[$index] = $this->replaceMiddlewareSlugs($baseMiddleware);
        }
        $thisMiddlewares = [];
        foreach ($this->middlewares() as $index => $thisMiddleware) {
            $thisMiddlewares[$index] = $this->replaceMiddlewareSlugs($thisMiddleware);
        }
        return array_merge($middlewares, $thisMiddlewares);
    }

    /**
     * Replaces slugs within middlewares . slug can be @class or @slug
     * which will be replaced respectively by the entity class and
     * the entity route key
     * 
     * @param array $middlewares
     * 
     * @return array
     */
    protected function replaceMiddlewareSlugs($middlewares)
    {
        $out = [];
        $middlewares = Arr::wrap($middlewares);
        foreach ($middlewares as $middleware) {
            $middleware = str_replace('@class', get_class($this->object), $middleware);
            $out[] = str_replace('@slug', $this->object::routeSlug(), $middleware);
        }
        return $out;
    }

    /**
     * Resolve the default controller for a route index.
     * Will look into the controller folder for a class named {entityClass}{index}Controller.
     * So for an entity called Brick and an index 'web', the controller class would be BrickWebController.
     * Will return the default entity controller if not found.
     * 
     * @param  string $index
     * @return string
     */
    protected function defaultController(string $index): string
    {
        $class = $this->controllerNamespace().'\\'.class_basename(get_class($this->object)).ucfirst($index).'Controller';
        if (!class_exists($class)) {
            $class = 'Pingu\\Entity\\Http\\Controllers\\'.ucfirst($index).'EntityController';
        }
        return $class;
    }

    /**
     * Find the controller namespace for an entity.
     * Will go back the namespace of the entity to find 'Entity', then add 'Http\Controller' to it.
     * 
     * @return string
     */
    protected function controllerNamespace(): string
    {
        $namespace = get_class($this->object);
        $elems = explode('\\', $namespace);
        while (last($elems) != 'Entities') {
            if (sizeof($elems) == 0) {
                break;
            }
            unset($elems[sizeof($elems)-1]);
        }
        unset($elems[sizeof($elems)-1]);
        $namespace = implode('\\', $elems);
        return $namespace.'\\Http\\Controllers';
    }

    /**
     * Registers the routes for an index (admin, web, etc) into Laravel Routes system
     * 
     * @param string $routeIndex
     */
    protected function mapEntityRoutes(string $routeIndex)
    {
        if (!$routes = $this->getRoutes($routeIndex)) {
            return;
        }

        $defaultController = $this->defaultController($routeIndex);

        foreach ($routes as $name) {
            $path = $routeIndex.'.'.$name;
            $method = $this->getMethods($name);
            $controller = $this->getControllers($path) ?? $defaultController;

            if (!strpos($controller, '@')) {
                $controller .= '@'.$name;
            }

            $uri = $this->object->uris()->get($name);

            $action = ['uses' => $controller, 'entity' => $this->object];

            $route = \Route::$method($uri, $action);

            if ($routeName = $this->getNames($path)) {
                $route->name($routeName);
            }
            if ($middleware = $this->getMiddlewares($name)) {
                $route->middleware($middleware);
            }
        }
    }

    /**
     * Registers all the web routes into Laravel Route system
     */
    protected function mapWebRoutes()
    {
        $routes = $this;
        \Route::middleware(['web', 'permission:browse site'])
            ->group(
                function () use ($routes) {
                    $routes->mapEntityRoutes('web');
                }
            );
    }

    /**
     * Registers all the ajax routes into Laravel Route system
     */
    protected function mapAjaxRoutes()
    {
        $routes = $this;
        \Route::prefix(ajaxPrefix())
            ->middleware('ajax')
            ->group(
                function () use ($routes) {
                    $routes->mapEntityRoutes('ajax');
                }
            );
    }

    /**
     * Registers all the admin routes into Laravel Route system
     */
    protected function mapAdminRoutes()
    {
        $routes = $this;
        \Route::middleware(['web', 'permission:access admin area'])
            ->prefix(adminPrefix())
            ->group(
                function () use ($routes) {
                    $routes->mapEntityRoutes('admin');
                }
            );
    }

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->mapAdminRoutes();
        $this->mapWebRoutes();
        $this->mapAjaxRoutes();
    }
}