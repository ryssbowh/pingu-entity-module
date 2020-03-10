<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Illuminate\Database\Eloquent\Collection;
use Pingu\Entity\Entities\Entity;

trait IndexesAdminEntity
{
    use IndexesEntity;

    /**
     * @inheritDoc
     */
    protected function onIndexSuccess(Entity $entity, Collection $entities)
    {
        return $this->getIndexView($entity, $entities);
    }

    /**
     * Get the view for a create request
     *
     * @param Entity     $entity
     * @param Collection $entities
     * 
     * @return view
     */
    protected function getIndexView(Entity $entity, Collection $entities)
    {
        $createUrl = $entity::uris()->make('create', [], adminPrefix());
        $with = [
            'total' => $entities->count(),
            'entities' => $entities,
            'entity' => $entity,
            'createUrl' => $createUrl,
            'type' => class_machine_name($entity)
        ];
        $this->addVariablesToIndexView($with);
        return view()->first($this->getIndexViewNames($entity), $with);
    }

    /**
     * View name for creating models
     *
     * @param Entity $entity
     * 
     * @return string
     */
    protected function getIndexViewNames(Entity $entity)
    {
        return ['pages.entities.'.$entity->entityType().'.index', 'pages.entities.index'];
    }

    /**
     * Callback to add variables to the view
     * 
     * @param array &$with
     */
    protected function addVariablesToIndexView(array &$with)
    {
    }
}
