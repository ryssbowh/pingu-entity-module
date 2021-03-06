<?php

namespace Pingu\Entity\Support\Routes;

use Illuminate\Support\Arr;
use Pingu\Core\Support\Routes;
use Pingu\Entity\Http\Controllers\EntityCrudContextController;
use Pingu\Entity\Support\Entity;
use Pingu\Page\Entities\Page;

class BaseEntityRoutes extends Routes
{
    /**
     * @var Entity
     */
    protected $entity;

    /**
     * Route class for Entity
     * @var EntityRoutes
     */
    protected $baseEntityRoutes;

    /**
     * Does this entity inherit the base CRUD Entity routes
     * @var boolean
     */
    protected $inheritsEntityRoutes = true;

    /**
     * Constructor. Will merge the routes, methods, middlewares, names and controllers
     * from the base entity routes which can be overriden by extended classes
     * 
     * @param HasUrisContract $entity
     */
    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
        $this->baseEntityRoutes = \Routes::get(Entity::class);
        if ($this->inheritsEntityRoutes) {
            $this->routes = array_merge_recursive($this->baseEntityRoutes->getRoute(), $this->routes());
        } else {
            $this->routes = $this->routes();
        }
        $this->middlewares = $this->replaceMiddlewareSlugs(array_merge($this->getBaseEntityMiddlewares(), $this->middlewares()));
        $this->methods = array_merge($this->baseEntityRoutes->getMethod(), $this->methods());
        $this->names = array_merge($this->baseEntityRoutes->getName(), $this->names());
        $this->controllers = array_merge($this->baseEntityRoutes->getController(), $this->controllers());
        $this->controllerActions = array_merge($this->baseEntityRoutes->getControllerAction(), $this->controllerActions());
        $this->contexts = array_merge($this->baseEntityRoutes->getContext(), $this->contexts());
    }

    protected function getBaseEntityMiddlewares()
    {
        return $this->baseEntityRoutes->getMiddleware();
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
            $middleware = str_replace('@class', get_class($this->entity), $middleware);
            $out[] = str_replace('@slug', $this->entity::routeSlug(), $middleware);
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
        $class = $this->controllerNamespace().'\\'.class_basename(get_class($this->entity)).'Controller';
        if (!class_exists($class)) {
            $class = EntityCrudContextController::class;
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
        $namespace = get_class($this->entity);
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
        if (!$routes = $this->getRoute($routeIndex)) {
            return;
        }
        $defaultController = $this->defaultController($routeIndex);
        foreach ($routes as $name) {
            $path = $routeIndex.'.'.$name;
            $method = $this->getMethod($name);
            $controller = $this->getController($path) ?? $defaultController;

            if (!strpos($controller, '@')) {
                $controller .= '@'.$this->getControllerAction($name);
            }

            $uri = $this->entity->uris()->get($name);

            $action = [
                'uses' => $controller, 
                'entity' => $this->entity, 
                'scope' => $routeIndex,
                'context' => $this->getContext($path)
            ];

            $route = \Route::$method($uri, $action);

            if (get_class($this->entity) == Page::class){
                // dump($uri, $method);
            }

            if (!$routeName = $this->getName($path)) {
                $routeName = $this->entity::routeSlug().'.'.$routeIndex.'.'.$name; 
            }
            $route->name($routeName);
            if ($middleware = $this->getMiddleware($name)) {
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