<?php

namespace Pingu\Entity\Traits;

trait HasViewModes
{
    /**
     * Boots trait, register entity in ViewMdoe facade
     */
    public static function bootHasViewModes()
    {
        static::registered(
            function ($entity) {
                \ViewMode::registerEntity($entity);
            }
        );
    }

    /**
     * Returns view modes used for this entity
     * 
     * @return array
     */
    public function getViewModes(): array
    {
        return \ViewModes::forEntity($this);   
    }
}