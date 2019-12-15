<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Forms\CreateLayoutGroupForm;

trait IndexesFormLayout
{
    public function formLayout(BundleContract $bundle)
    {
        \ContextualLinks::addFromObject($bundle);
        $entity = $bundle->entityFor(); 
        $entity = new $entity;
        return view('entity::indexFormLayout')->with([
            'fields' => $entity->fields(),
            'layout' => $bundle->formLayout(),
            'bundle' => $bundle,
            'canCreateGroups' => \Gate::check('createGroups', $bundle),
            'createGroupForm' => new CreateLayoutGroupForm($entity)
        ]);
    }
}
