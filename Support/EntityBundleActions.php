<?php

namespace Pingu\Entity\Support;

use Pingu\Entity\Support\EntityBundle;

class EntityBundleActions extends BaseEntityActions
{
    /**
     * Make the actions for this bundle.
     * This method can be called either with the entity of the bundle as parameter
     * 
     * @param $object
     * 
     * @return array
     */
    public function make($object): array
    {
        if ($object instanceof EntityBundle) {
            //Needs to build the actions for the bundle object
            $entityActions = parent::make($object->getEntity());
            $bundleActions = \Actions::get($object)->make($object);
        } else {
            //Needs to build the actions for the entity object
            $entityActions = parent::make($object);
            $bundleActions = \Actions::get($object->bundle())->make($object->bundle());
        }
        
        return array_merge($entityActions, $bundleActions);
    }
}
