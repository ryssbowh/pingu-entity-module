<?php

namespace Pingu\Entity\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Router;
use Pingu\Core\Support\ModuleServiceProvider;
use Pingu\Entity\Bundle;
use Pingu\Entity\Entities\Entity as EntityModel;
use Pingu\Entity\Entities\ViewMode as ViewModeModel;
use Pingu\Entity\Entities\ViewModesEntities;
use Pingu\Entity\Entity;
use Pingu\Entity\FieldDisplay;
use Pingu\Entity\FieldLayout;
use Pingu\Entity\Http\Middleware\HasRevisions;
use Pingu\Entity\Observers\ViewModeEntitiesObserver;
use Pingu\Entity\Observers\ViewModeObserver;
use Pingu\Entity\Support\BaseBundleActions;
use Pingu\Entity\Support\BaseBundleUris;
use Pingu\Entity\Support\Bundle as BundleAbstract;
use Pingu\Entity\Support\EntityActions;
use Pingu\Entity\Support\EntityUris;
use Pingu\Entity\Support\Routes\BaseBundleRoutes;
use Pingu\Entity\Support\Routes\EntityRoutes;
use Pingu\Entity\ViewMode;
use Pingu\Field\Entities\FormLayout;

class EntityServiceProvider extends ModuleServiceProvider
{
    protected $entities = [
        ViewModeModel::class
    ];

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->aliasMiddleware('hasRevisions', HasRevisions::class);
        $this->registerConfig();
        $this->registerJsConfig();
        $this->registerEntities($this->entities);

        ViewModeModel::observe(ViewModeObserver::class);
        ViewModesEntities::observe(ViewModeEntitiesObserver::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('entity.entity', Entity::class);
        $this->app->singleton('entity.bundle', Bundle::class);
        $this->app->singleton('entity.display', FieldDisplay::class);
        $this->app->singleton('entity.layout', FieldLayout::class);
        $this->app->singleton('entity.viewMode', ViewMode::class);
        //Registers base bundle uris
        \Uris::register(BundleAbstract::class, new BaseBundleUris);
        //Binds bundle slug in Route system
        \Route::bind(
            'bundle', function ($value, $route) {
                return \Bundle::get($value);
            }
        );
        //Registers base bundle routes
        \Routes::register(BundleAbstract::class, new BaseBundleRoutes);
        //Register base entity routes
        \Routes::register(EntityModel::class, new EntityRoutes);
        //Register base entity uris
        \Uris::register(EntityModel::class, new EntityUris);
        //Register base entity actions
        \Actions::register(EntityModel::class, new EntityActions);
    }

    protected function registerJsConfig()
    {
        $this->app->booted(function () {
            \JsConfig::setMany(
                [
                'entity.uris.viewFieldLayoutOptions' => route_by_name('entity.ajax.viewFieldLayoutOptions')->uri(),
                'entity.uris.editFieldLayoutOptions' => route_by_name('entity.ajax.editFieldLayoutOptions')->uri(),
                'entity.uris.viewFieldDisplayOptions' => route_by_name('entity.ajax.viewFieldDisplayOptions')->uri(),
                'entity.uris.editFieldDisplayOptions' => route_by_name('entity.ajax.editFieldDisplayOptions')->uri(),
                ]
            );
        });
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'entity'
        );
        $this->replaceConfigFrom(
            __DIR__.'/../Config/modules.php', 'modules'
        );
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('entity.php')
        ], 'entity-config');
    }
}
