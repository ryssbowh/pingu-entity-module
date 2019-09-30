<?php

namespace Pingu\Entity\Providers;

use Illuminate\Database\Eloquent\Factory;
use Pingu\Core\Support\ModuleServiceProvider;
use Pingu\Entity\BundleField as BundleFieldFacade;
use Pingu\Entity\Entities\BundleField;
use Pingu\Entity\Entities\Fields\FieldBoolean;
use Pingu\Entity\Entities\Fields\FieldDatetime;
use Pingu\Entity\Entities\Fields\FieldEmail;
use Pingu\Entity\Entities\Fields\FieldFloat;
use Pingu\Entity\Entities\Fields\FieldInteger;
use Pingu\Entity\Entities\Fields\FieldSlug;
use Pingu\Entity\Entities\Fields\FieldText;
use Pingu\Entity\Entities\Fields\FieldTextLong;
use Pingu\Entity\Entities\Fields\FieldUrl;
use Pingu\Entity\Entity;

class EntityServiceProvider extends ModuleServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfig();
        $this->registerBundleFields();
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'entity');
        $this->extendValidationRules();

        \ModelRoutes::registerSlugFromObject(new BundleField);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->singleton('core.entity', Entity::class);
        $this->app->singleton('core.entity.field', BundleFieldFacade::class);
    }

    protected function registerBundleFields()
    {
        \BundleField::registerBundleFields([
            FieldBoolean::class,
            FieldDatetime::class,
            FieldEmail::class,
            FieldFloat::class,
            FieldInteger::class,
            FieldText::class,
            FieldTextLong::class,
            FieldUrl::class,
            FieldSlug::class
        ]);
    }

    public function extendValidationRules()
    {
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
    }
}
