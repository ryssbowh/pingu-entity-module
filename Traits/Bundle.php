<?php 

namespace Pingu\Entity\Traits;

use Pingu\Core\Support\Actions;
use Pingu\Core\Support\Routes;
use Pingu\Core\Support\Uris;
use Pingu\Entity\Support\FieldDisplay\FieldDisplay;
use Pingu\Entity\Support\FieldLayout\FieldLayout;
use Pingu\Entity\Support\FieldRepository\BundleFieldsRepository;
use Pingu\Entity\Support\FieldValidator\BundleFieldsValidator;
use Pingu\Entity\Support\Policies\BaseBundlePolicy;
use Pingu\Field\Contracts\FieldRepository;
use Pingu\Field\Contracts\FieldsValidator;

trait Bundle
{
    /**
     * Gets the field repository for this model by loading it through the Field Facade
     * 
     * @return FieldRepository
     */
    public function fields(): FieldRepository
    {
        $_this = $this;
        return \Field::getFieldRepository(
            $this->identifier(),
            function () use ($_this) {
                return new BundleFieldsRepository($_this);
            }
        );
    }

    /**
     * Gets the field validator for this model by loading it through the Field Facade
     * 
     * @return FieldRepository
     */
    public function validator(): FieldsValidator
    {
        $_this = $this;
        return \Field::getFieldsValidator(
            $this->identifier(),
            function () use ($_this) {
                return new BundleFieldsValidator($_this);
            }
        );
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
    public static function actions(): Actions
    {
        return \Actions::get('bundle');
    }
}