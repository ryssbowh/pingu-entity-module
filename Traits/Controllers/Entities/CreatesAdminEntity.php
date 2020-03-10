<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Entities\Entity;
use Pingu\Forms\Support\Form;

trait CreatesAdminEntity
{
    use CreatesEntity;

    /**
     * @inheritDoc
     */
    protected function onCreateFormCreated(Form $form, Entity $entity)
    {
        return $this->getCreateView($form, $entity);
    }

    /**
     * Get the view for a create request
     * 
     * @param Form   $form
     * @param Entity $entity
     *
     * @return view
     */
    protected function getCreateView(Form $form, Entity $entity)
    {
        $with = [
            'form' => $form,
            'entity' => $entity,
        ];
        $this->addVariablesToCreateView($with, $entity);
        return view()->first($this->getCreateViewNames($entity), $with);
    }

    /**
     * View name for creating models
     *
     * @param Entity $entity
     * 
     * @return string
     */
    protected function getCreateViewName(Entity $entity)
    {
        return ['pages.entities.'.$entity->entityType().'.create', 'pages.entities.create'];
    }

    /**
     * Callback to add variables to the view
     *
     * @param Entity $entity
     * 
     * @param array  &$with
     */
    protected function addVariablesToCreateView(array &$with, Entity $entity)
    {
    }

    /**
     * @inheritDoc
     */
    protected function getStoreUriPrefix()
    {
        return adminPrefix();
    }

}
