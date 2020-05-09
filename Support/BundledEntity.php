<?php

namespace Pingu\Entity\Support;

use Pingu\Core\Contracts\RendererContract;
use Pingu\Core\Support\Routes;
use Pingu\Core\Support\Uris\Uris;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Support\FieldDisplay\FieldDisplay;
use Pingu\Entity\Support\FieldLayout\FieldLayout;
use Pingu\Entity\Support\Forms\BundledEntityForms;
use Pingu\Entity\Support\Renderers\BundledEntityRenderer;
use Pingu\Entity\Support\Routes\BundledEntityRoutes;
use Pingu\Entity\Support\Uris\BundledEntityUris;
use Pingu\Field\Traits\HasBundleFields;
use Pingu\Forms\Contracts\FormRepositoryContract;

abstract class BundledEntity extends Entity
{
    use HasBundleFields;

    /**
     * @var ?BundleContract
     */
    protected $bundle;
    
    /**
     * Bundle name getter
     * 
     * @return string
     */
    abstract public function bundleClass(): ?string;

    /**
     * Bundle instance
     * 
     * @return ?BundleContract
     */
    abstract protected function bundleInstance(): ?BundleContract;

    /**
     * @inheritDoc
     */
    public function setBundle(BundleContract $bundle)
    {
        $this->bundle = $bundle;
        $this->fillable($this->getFillable());
    }

    /**
     * Bundle getter
     * 
     * @return ?BundleContract
     */
    public function bundle(): ?BundleContract
    {
        if (!$this->bundle) {
            $this->bundle = $this->bundleInstance();
        }
        return $this->bundle;
    }

    /**
     * @inheritDoc
     */
    public function viewIdentifier(): string
    {
        return \Str::kebab($this->bundle()->name());
    }

    /**
     * @inheritDoc
     */
    protected static function defaultUrisInstance(): Uris
    {
        return new BundledEntityUris(static::class);
    }

    /**
     * @inheritDoc
     */
    public function defaultRouteInstance(): Routes
    {
        return new BundledEntityRoutes($this);
    }

    /**
     * @inheritDoc
     */
    public static function forms(): FormRepositoryContract
    {
        return new BundledEntityForms;
    }

    /**
     * Get field layout instance from Field facade
    */
    public function fieldLayout(): FieldLayout
    {
        return $this->bundle()->fieldLayout();
    }

    /**
     * Get field display instance from Field facade
    */
    public function fieldDisplay(): FieldDisplay
    {
        return $this->bundle()->fieldDisplay();
    }
}