<?php

namespace Pingu\Entity\Traits;

trait MapsEntityRoutes
{
	protected function controllerNamespace(): string
    {
        $namespace = get_class($this->object);
        $elems = explode('\\', $namespace);
        while(last($elems) != 'Entities'){
            if(sizeof($elems) == 0){
                break;
            }
            unset($elems[sizeof($elems)-1]);
        }
        unset($elems[sizeof($elems)-1]);
        $namespace = implode('\\', $elems);
        return $namespace.'\\Http\\Controllers';
    }

    protected function mapEntityRoutes(string $routeIndex)
    {
        $routes = $this->routes();
        if(!isset($routes[$routeIndex])){
            return;
        }

        $controllerNamespace = $this->controllerNamespace();
        $defaultController = $this->defaultController($routeIndex);

        foreach($routes[$routeIndex] as $name){
            $path = $routeIndex.'.'.$name;
            $method = $this->getRouteMethod($name);
            if(!$controller = $this->getRouteController($path, $controllerNamespace)){
                $controller = $defaultController;
            }
            $action = $controller.'@'.$name;
            // dump($action.' => '.$this->getRouteUri($name). ' ('.$routeIndex.')');
            $route = \Route::$method($this->getRouteUri($name), $this->getRouteParams($name, $action));
            if($name = $this->getRouteName($path)){
                $route->name($name);
            }
            if($middleware = $this->getRouteMiddleware($name)){
                $route->middleware($middleware);
            }
        }
    }

    protected function routeMiddlewares(): array
    {
        return [];
    }

    protected function routeNames(): array
    {
        return [];
    }

    protected function routeParams(): array
    {
        return [];
    }

    protected function routeControllers(): array
    {
        return [];
    }

    protected function getRouteMethod(string $name): string
    {
        return $this->routeMethods()[$name] ?? 'get';
    }

    protected function getRouteName(string $path)
    {
        return $this->routeNames()[$path] ?? false;
    }

    protected function getRouteMiddleware(string $name)
    {
        return $this->routeMiddlewares()[$name] ?? false;
    }

    protected function getRouteController(string $path, string $namespace)
    {
        return isset($this->routeControllers()[$path]) ? $namespace.'\\'.$this->routeControllers()[$path] : false;
    }
}