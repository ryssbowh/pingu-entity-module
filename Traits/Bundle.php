<?php

namespace Pingu\Entity\Traits;

use Illuminate\Support\Collection;
use Pingu\Core\Contracts\ActionRepositoryContract;
use Pingu\Core\Contracts\RouteContexts\RouteContextRepositoryContract;
use Pingu\Core\Support\Actions;
use Pingu\Core\Support\Routes;
use Pingu\Core\Support\Uris\Uris;
use Pingu\Core\Traits\Models\HasRouteContexts;
use Pingu\Entity\Support\Contexts\BundleContextRepository;
use Pingu\Entity\Support\FieldDisplay\FieldDisplay;
use Pingu\Entity\Support\FieldLayout\FieldLayout;
use Pingu\Entity\Support\FieldRepository\BundleFieldsRepository;
use Pingu\Entity\Support\Policies\BaseBundlePolicy;
use Pingu\Field\Contracts\FieldRepositoryContract;
use Pingu\Field\Traits\HasFields;

trait Bundle
{
    use HasFields, HasRouteContexts;

    /**
     * @inheritDoc
     */
    public static function contextRepositoryClass(): RouteContextRepositoryContract
    {
        return new BundleContextRepository(static::$routeContexts);
    }

    /**
     * @inheritDoc
     */
    public function fieldRepositoryInstance(): FieldRepositoryContract
    {
        return new BundleFieldsRepository($this);
    }

    /**
     * @inheritDoc
     */
    public function getPolicy(): string
    {
        return BaseBundlePolicy::class;
    }

    /**
     * @inheritDoc
     */
    public function fieldLayout(): FieldLayout
    {
        return \FieldLayout::getFieldLayout($this)->load();
    }

    /**
     * @inheritDoc
     */
    public function fieldDisplay(): FieldDisplay
    {
        return \FieldDisplay::getFieldDisplay($this)->load();
    }

    /**
     * @inheritDoc
     */
    public function getRouteKey(): string
    {
        return $this->name();
    }

    /**
     * @inheritDoc
     */
    public function identifier(): string
    {
        return 'bundle-'.$this->name();
    }

    /**
     * @inheritDoc
     */
    public static function uris(): Uris
    {
        return \Uris::get('bundle');
    }

    /**
     * @inheritDoc
     */
    public static function routes(): Routes
    {
        return \Routes::get('bundle');
    }

    /**
     * @inheritDoc
     */
    public static function actions(): ActionRepositoryContract
    {
        return \Actions::get('bundle');
    }

    /**
     * @inheritDoc
     */
    public function entities(): Collection
    {
        return $this->entityFor()::get();
    }
}