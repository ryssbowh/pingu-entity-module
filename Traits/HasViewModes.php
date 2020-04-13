<?php

namespace Pingu\Entity\Traits;

use Pingu\Entity\Support\BundledEntity;

trait HasViewModes
{
    /**
     * Boots trait, register entity in View Mode facade
     */
    public static function bootHasViewModes()
    {
        static::registered(
            function ($entity) {
                if ($entity instanceof BundledEntity) {
                    foreach ($entity->bundleClass()::allBundles() as $bundle) {
                        \ViewMode::registerObject($bundle);
                    }
                } else {
                    \ViewMode::registerObject($entity);
                }
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