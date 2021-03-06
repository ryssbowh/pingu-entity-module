<?php

namespace Pingu\Entity\Traits;

use Pingu\Entity\Support\FieldLayout\FieldLayout;

trait HasFieldLayout
{
    public static function bootHasFieldLayout()
    {
        static::registered(
            function ($entity) {
                $entity->registerFieldLayout();
            }
        );
    }

    /**
     * Register form layout instance in FieldLayout facade
     */
    public function registerFieldLayout()
    {
        \FieldLayout::register($this, new FieldLayout($this));
    }

    /**
     * Get form layout instance from FieldLayout facade
     */
    public function fieldLayout(): FieldLayout
    {
        return \FieldLayout::getFieldLayout($this)->load();
    }
}