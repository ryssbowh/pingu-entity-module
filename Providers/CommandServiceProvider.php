<?php

namespace Pingu\Entity\Providers;

use Illuminate\Support\ServiceProvider;
use Pingu\Entity\Console\ModuleMakeEntity;
use Pingu\Entity\Console\ModuleMakeEntityActions;
use Pingu\Entity\Console\ModuleMakeEntityPolicy;
use Pingu\Entity\Console\ModuleMakeEntityRoutes;
use Pingu\Entity\Console\ModuleMakeEntityUris;

class CommandServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    protected $commands = [
        'command.moduleMakeEntity',
        'command.moduleMakeEntityPolicy',
        'command.ModuleMakeEntityRoutes',
        'command.ModuleMakeEntityActions',
        'command.ModuleMakeEntityUris'
    ];
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();
    }
    /**
     * Registers the serve command
     */
    protected function registerCommands()
    {
        $this->app->bind(
            'command.moduleMakeEntity', function ($app) {
                return new ModuleMakeEntity();
            }
        );
        $this->app->bind(
            'command.moduleMakeEntityPolicy', function ($app) {
                return new ModuleMakeEntityPolicy();
            }
        );
        $this->app->bind(
            'command.ModuleMakeEntityRoutes', function ($app) {
                return new ModuleMakeEntityRoutes();
            }
        );
        $this->app->bind(
            'command.ModuleMakeEntityActions', function ($app) {
                return new ModuleMakeEntityActions();
            }
        );
        $this->app->bind(
            'command.ModuleMakeEntityUris', function ($app) {
                return new ModuleMakeEntityUris();
            }
        );
        $this->commands($this->commands);
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return $this->commands;
    }
}