<?php

namespace Pingu\Entity\Http\Controllers;

use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Support\ModelCrudContextController;

class EntityCrudContextController extends ModelCrudContextController
{
    /**
     * @inheritDoc
     */
    protected function getModel(): BaseModel
    {
        $entity = $this->getRouteAction('entity');
        $bundle = $this->request->route('bundle');
        if ($bundle) {
            $entity->setBundle($bundle);
        }
        return $entity;
    }
}