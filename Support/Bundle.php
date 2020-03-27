<?php

namespace Pingu\Entity\Support;

use Pingu\Core\Support\Accessor;
use Pingu\Core\Support\Actions;
use Pingu\Core\Support\Routes;
use Pingu\Core\Support\Uris;
use Pingu\Core\Traits\HasActionsThroughFacade;
use Pingu\Core\Traits\HasRoutesThroughFacade;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Facades\Bundle as BundleFacade;
use Pingu\Entity\Support\BaseBundleActions;
use Pingu\Entity\Support\BaseBundleUris;
use Pingu\Entity\Support\FieldDisplay\FieldDisplay;
use Pingu\Entity\Support\FieldDisplay\FieldDisplayBundle;
use Pingu\Entity\Support\FieldLayout\FieldLayout;
use Pingu\Entity\Support\FieldLayout\FieldLayoutBundle;
use Pingu\Entity\Traits\HasActions;
use Pingu\Field\Contracts\FieldContract;
use Pingu\Field\Contracts\FieldRepository;
use Pingu\Field\Contracts\FieldsValidator;
use Pingu\Field\Support\FieldRepository\BundleFieldsRepository;
use Pingu\Forms\Support\Field;

abstract class Bundle implements BundleContract
{
    use HasActionsThroughFacade,
        HasRoutesThroughFacade;

    /**
     * @inheritDoc
     */
    public function getField(string $name): FieldContract
    {
        return $this->fields()->get($name);
    }

    /**
     * @inheritDoc
     */
    public function fields(): FieldRepository
    {
        $_this = $this;
        return \Field::getFieldRepository(
            $this,
            function () use ($_this) {
                return new BundleFieldsRepository($_this);
            }
        );
    }

    /**
     * @inheritDoc
     */
    public function validator(): FieldsValidator
    {
        $_this = $this;
        return \Field::getFieldsValidator(
            $this,
            function () use ($_this) {
                return $_this->getFieldsValidator();
            }
        );
    }

    /**
     * @inheritDoc
     */
    public function formLayout(): FieldLayout
    {
        return \FieldLayout::getBundleFormLayout($this)->load();
    }

    /**
     * @inheritDoc
     */
    public function display(): FieldDisplay
    {
        return \FieldDisplay::getBundleDisplay($this)->load();
    }

    /**
     * Actions class for this bundle
     * 
     * @return Actions
     */
    protected function getActionsInstance(): Actions
    {
        return new BaseBundleActions($this);
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
    public static function uris(): Uris
    {
        return \Uris::get(Bundle::class);
    }

    /**
     * @inheritDoc
     */
    public function getRouteKey(): string
    {
        return $this->bundleName();
    }

    /**
     * Registers this bundle
     */
    public function register()
    {
        BundleFacade::registerBundle($this);
        \Actions::register(get_class($this), $this->getActionsInstance());
        \FieldLayout::register($this->bundleName(), new FieldLayoutBundle($this));
        \FieldDisplay::register($this->bundleName(), new FieldDisplayBundle($this));
        \Policies::register($this, $this->getPolicy());
    }
}