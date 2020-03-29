<?php

namespace Pingu\Entity\Traits;

use Pingu\Entity\Support\FieldDisplay\FieldDisplay;

trait HasFieldDisplay
{
    public static function bootHasFieldDisplay()
    {
        static::registered(
            function ($entity) {
                $entity->registerFieldDisplay();
            }
        );
    }

    /**
     * Register form layout instance in Field facade
     */
    public function registerFieldDisplay()
    {
        \FieldDisplay::register($this, new FieldDisplay($this));
    }

    /**
     * Get form layout instance from Field facade
     */
    public function fieldDisplay(): FieldDisplay
    {
        return \FieldLayout::getFieldDisplay($this)->load();
    }
}