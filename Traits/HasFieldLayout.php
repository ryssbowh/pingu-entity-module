<?php

namespace Pingu\Entity\Traits;

use Pingu\Entity\Support\FieldLayout\FieldLayout;

trait HasFieldLayout
{
    public static function bootHasFieldLayout()
    {
        static::registered(
            function ($entity) {
                $entity->registerFormLayout();
            }
        );
    }

    /**
     * Register form layout instance in Field facade
     */
    public function registerFormLayout()
    {
        \FieldLayout::register(get_class($this), new FieldLayout($this));
    }

    /**
     * Get form layout instance from Field facade
     */
    public function formLayout(): FieldLayout
    {
        return \FieldLayout::getEntityFormLayout($this)->load();
    }
}