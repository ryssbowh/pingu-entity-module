<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Pingu\Entity\Entities\Entity;
use Pingu\Forms\Support\Form;

trait IndexesAdminEntity
{
    use IndexesEntity;

    /**
     * @inheritDoc
     */
    protected function onIndexSuccess(Entity $entity, LengthAwarePaginator $entities)
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
    protected function getIndexView(Entity $entity, LengthAwarePaginator $entities)
    {
        $createUrl = $entity::uris()->make('create', [], adminPrefix());
        $with = [
            'entities' => $entities,
            'entity' => $entity,
            'createUrl' => $createUrl,
            'filterForm' => $this->getIndexFilterForm($entity)
        ];
        $this->addVariablesToIndexView($with);
        return view()->first($this->getIndexViewNames($entity), $with);
    }

    /**
     * Get the form to filter an entity
     *
     * @param Entity $entity
     *
     * @return Form
     */
    protected function getIndexFilterForm(Entity $entity): Form
    {
        $indexUrl = $entity::uris()->make('index', [], adminPrefix());
        return $entity->forms()->filter($entity->getFilterable(), ['url' => $indexUrl]);
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
